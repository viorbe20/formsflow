<?php

namespace App\Services;

use App\Enums\RequestCategory;
use App\Enums\RequestPriority;
use Illuminate\Support\Str;

class RequestNLPClassifier
{
    /**
     * Classify a request text.
     */
    public function classify(string $text): array
    {
        $normalizedText = $this->normalizeText($text);

        return [
            'category' => $this->classifyCategory($normalizedText),
            'priority' => $this->classifyPriority($normalizedText),
        ];
    }

    /**
     * Normalize the text before classification.
     */
    private function normalizeText(string $text): string
    {
        $text = Str::lower($text);
        $text = Str::ascii($text);

        return preg_replace('/\s+/', ' ', trim($text));
    }

    /**
     * Classify the request category using weighted terms.
     */
    private function classifyCategory(string $text): string
    {
        $categoryTerms = [
            RequestCategory::INFORMATION->value => [
                'informacion' => 1,
                'consulta' => 2,
                'saber' => 1,
                'requisitos' => 2,
                'procedimiento' => 2,
                'tramite' => 1,
                'como realizar' => 2,
                'donde puedo' => 2,
            ],

            RequestCategory::INCIDENT->value => [
                'problema' => 2,
                'error' => 3,
                'fallo' => 3,
                'no funciona' => 3,
                'no puedo acceder' => 3,
                'no puedo completar' => 3,
                'no permite' => 3,
                'bloqueado' => 3,
            ],

            RequestCategory::DOCUMENTATION->value => [
                'documentacion' => 2,
                'documento' => 2,
                'certificado' => 2,
                'justificante' => 2,
                'acreditacion' => 2,
                'copia' => 1,
                'resguardo' => 2,
            ],
        ];

        $scores = [];

        foreach ($categoryTerms as $category => $terms) {
            $scores[$category] = $this->calculateScore(
                $text,
                $terms
            );
        }

        arsort($scores);

        return array_key_first($scores);
    }

    /**
     * Classify the request priority using weighted terms.
     */
    private function classifyPriority(string $text): string
    {
        $highPriorityTerms = [
            'servicio no disponible' => 3,
            'todos los usuarios' => 3,
            'ningun usuario' => 3,
            'ninguna solicitud' => 3,
            'bloqueado' => 3,
            'urgente' => 3,
            'desde hace horas' => 3,
        ];

        $mediumPriorityTerms = [
            'problema' => 1,
            'error' => 1,
            'fallo' => 1,
            'no funciona' => 1,
            'no puedo acceder' => 1,
            'no puedo completar' => 1,
            'no permite' => 1,
            'impidiendo' => 1,
            'dificultad' => 1,
        ];

        $highScore = $this->calculateScore(
            $text,
            $highPriorityTerms
        );

        $mediumScore = $this->calculateScore(
            $text,
            $mediumPriorityTerms
        );

        if ($highScore >= 3) {
            return RequestPriority::HIGH->value;
        }

        if ($mediumScore >= 1) {
            return RequestPriority::MEDIUM->value;
        }

        return RequestPriority::LOW->value;
    }

    /**
     * Calculate the score obtained from matching terms.
     */
    private function calculateScore(
        string $text,
        array $terms
    ): int {
        $score = 0;

        foreach ($terms as $term => $weight) {
            if (str_contains($text, $term)) {
                $score += $weight;
            }
        }

        return $score;
    }
}
