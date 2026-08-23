<?php

namespace Database\Seeders;

use App\Models\ApplicationRequest;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Create realistic demonstration requests for FormsFlow.
     */
    public function run(): void
    {
        $requests = [
            // Education - 5 requests.
            [
                'organization' => 'Educación',
                'unit' => 'Dirección General de Innovación y Formación del Profesorado',
                'subject' => 'Información sobre un procedimiento',
                'statement' => 'Necesito información sobre el procedimiento y los pasos que debo seguir.',
                'request_text' => 'Quisiera saber cómo realizar este trámite y dónde puedo consultar la información disponible.',
                'status' => 'archived',
            ],
            [
                'organization' => 'Educación',
                'unit' => 'Dirección General de Planificación, Centros y Enseñanza Concertada',
                'subject' => 'Consulta sobre un trámite',
                'statement' => 'Tengo una consulta sobre un trámite administrativo.',
                'request_text' => 'Necesito saber cómo realizar el trámite y qué pasos debo seguir para completarlo correctamente.',
                'status' => 'archived',
            ],
            [
                'organization' => 'Educación',
                'unit' => 'Dirección General del Profesorado y Gestión de Recursos Humanos',
                'subject' => 'Información sobre el proceso de inscripción',
                'statement' => 'Quisiera obtener información sobre el proceso de inscripción.',
                'request_text' => 'Quisiera saber dónde puedo consultar la información sobre el proceso de inscripción.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Educación',
                'unit' => 'Dirección General de Innovación y Formación del Profesorado',
                'subject' => 'Consulta sobre el procedimiento',
                'statement' => 'Necesito aclarar algunas cuestiones relacionadas con un procedimiento.',
                'request_text' => 'Tengo una consulta y quisiera saber cómo realizar correctamente el procedimiento.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Educación',
                'unit' => 'Dirección General del Profesorado y Gestión de Recursos Humanos',
                'subject' => 'Error durante el registro',
                'statement' => 'Se produce un error al registrar la solicitud.',
                'request_text' => 'He encontrado un error durante el registro y no puedo completar el proceso.',
                'status' => 'archived',
            ],

            // Economy, Finance and European Funds - 4 requests.
            [
                'organization' => 'Economía, Hacienda y Fondos Europeos',
                'unit' => 'Dirección General de Contratación',
                'subject' => 'Documentación necesaria para un trámite',
                'statement' => 'Necesito conocer la documentación que debo aportar.',
                'request_text' => 'Quisiera saber qué documentación debo presentar para completar correctamente el trámite.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Economía, Hacienda y Fondos Europeos',
                'unit' => 'Dirección General de Patrimonio',
                'subject' => 'Documentos necesarios para la solicitud',
                'statement' => 'Quiero confirmar qué documentos son necesarios.',
                'request_text' => 'Necesito conocer los documentos que debo aportar junto con la solicitud.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Economía, Hacienda y Fondos Europeos',
                'unit' => 'Dirección General de Presupuestos',
                'subject' => 'Consulta sobre justificantes',
                'statement' => 'Necesito saber qué justificantes debo presentar.',
                'request_text' => 'Quisiera confirmar qué justificantes son necesarios para completar la solicitud.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Economía, Hacienda y Fondos Europeos',
                'unit' => 'Dirección General de Contratación',
                'subject' => 'Problema al completar una solicitud',
                'statement' => 'No puedo terminar una solicitud correctamente.',
                'request_text' => 'Tengo un problema porque no puedo completar la solicitud desde el formulario.',
                'status' => 'pending',
            ],

            // AI, Digital Development and Public Administration - 3 requests.
            [
                'organization' => 'IA, Desarrollo Digital y Administración Pública',
                'unit' => 'Dirección General de Desarrollo y Estrategia Digital',
                'subject' => 'Error al acceder al servicio',
                'statement' => 'Estoy teniendo un problema al utilizar el servicio.',
                'request_text' => 'No puedo acceder al servicio y aparece un error cuando intento entrar.',
                'status' => 'pending',
            ],
            [
                'organization' => 'IA, Desarrollo Digital y Administración Pública',
                'unit' => 'Dirección General de Inteligencia Artificial',
                'subject' => 'El servicio no funciona correctamente',
                'statement' => 'El servicio está presentando problemas.',
                'request_text' => 'El servicio no funciona correctamente y no puedo continuar con la gestión.',
                'status' => 'pending',
            ],
            [
                'organization' => 'IA, Desarrollo Digital y Administración Pública',
                'unit' => 'Dirección General de Planificación y Evaluación del Sector Público',
                'subject' => 'Servicio bloqueado durante un trámite',
                'statement' => 'El servicio se encuentra bloqueado y no permite continuar.',
                'request_text' => 'El servicio está bloqueado y no puedo completar el trámite. Necesito resolverlo con urgencia.',
                'status' => 'pending',
            ],

            // Presidency, Health and Emergencies - 2 requests.
            [
                'organization' => 'Presidencia, Sanidad y Emergencias',
                'unit' => 'Dirección General de Salud Digital y Ordenación Farmacéutica',
                'subject' => 'Servicio no disponible',
                'statement' => 'El servicio no está disponible y está afectando a la gestión.',
                'request_text' => 'El servicio no está disponible y necesito completar la solicitud de forma urgente.',
                'status' => 'pending',
            ],
            [
                'organization' => 'Presidencia, Sanidad y Emergencias',
                'unit' => 'Dirección General de Investigación, Innovación y Formación',
                'subject' => 'Incidencia urgente en el servicio',
                'statement' => 'Se ha producido una incidencia que impide continuar con la gestión.',
                'request_text' => 'El servicio está bloqueado y la incidencia es urgente porque no permite finalizar el trámite.',
                'status' => 'pending',
            ],
        ];

        foreach ($requests as $request) {
            ApplicationRequest::factory()->create([
                'organization' => $request['organization'],
                'unit' => $request['unit'],
                'subject' => $request['subject'],
                'statement' => $request['statement'],
                'request_text' => $request['request_text'],
                'status' => $request['status'],
                'category' => null,
                'priority' => null,
            ]);
        }
    }
}
