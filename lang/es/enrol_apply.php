<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    enrol_apply
 * @copyright  emeneo.com (http://emeneo.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     emeneo.com (http://emeneo.com/)
 * @author     Johannes Burk <johannes.burk@sudile.com>
 */

$string['applicationcancelednotification'] = 'Tu solicitud para unirte al curso no fue aceptada.';
$string['applicationconfirmednotification'] = 'Tu solicitud para unirte al curso fue confirmada.';
$string['applicationdeferrednotification'] = 'Tu solicitud para unirte al curso está en lista de espera.';
$string['apply:config'] = 'Configurar la matriculación con aprobación';
$string['apply:manage'] = 'Gestionar matrículas de usuarios';
$string['apply:manageapplications'] = 'Gestionar solicitudes de matrícula';
$string['apply:unenrol'] = 'Dar de baja a usuarios del curso';
$string['apply:unenrolself'] = 'Darse de baja del curso';
$string['applycomment'] = 'Comentario';
$string['applydate'] = 'Solicitado el';
$string['applymanage'] = 'Gestionar solicitudes de matrícula';
$string['applyuser'] = 'Nombre';
$string['applyusermail'] = 'Correo';
$string['btncancel'] = 'Rechazar solicitudes';
$string['btnconfirm'] = 'Confirmar solicitudes';
$string['btnwait'] = 'Pasar a lista de espera';
$string['cancelation_defaultcontent'] = '<p>Hola, {firstname}:</p><p>Esta vez tu solicitud para unirte a {content} no fue aceptada.</p>';
$string['cancelation_defaultsubject'] = 'Tu solicitud para {$a} no fue aceptada';
$string['cancelmail_desc'] = '';
$string['cancelmail_heading'] = 'Correo de rechazo';
$string['cancelmailcontent'] = 'Contenido del correo de rechazo';
$string['cancelmailcontent_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante. Marcas que se reemplazan con datos de Moodle: {firstname}, {lastname}, {username}, {content} (el nombre del curso), {courseurl} (el enlace al curso).';
$string['cancelmailsubject'] = 'Asunto del correo de rechazo';
$string['cancelmailsubject_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante.';
$string['cantenrol'] = 'La matriculación está desactivada o inactiva';
$string['comment'] = 'Comentario';
$string['confirmation_defaultcontent'] = '<p>Hola, {firstname}:</p><p>Tu solicitud fue confirmada: ya estás inscrito en <a href="{courseurl}">{content}</a>. También lo encontrarás en Mis cursos.</p>';
$string['confirmation_defaultsubject'] = 'Ya estás inscrito en {$a}';
$string['confirmenrol'] = 'Gestionar solicitudes';
$string['confirmmail_desc'] = '';
$string['confirmmail_heading'] = 'Correo de confirmación';
$string['confirmmailcontent'] = 'Contenido del correo de confirmación';
$string['confirmmailcontent_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante. Marcas que se reemplazan con datos de Moodle: {firstname}, {lastname}, {username}, {content} (el nombre del curso), {courseurl} (el enlace al curso), {timeend} (la fecha de fin de la matrícula).';
$string['confirmmailsubject'] = 'Asunto del correo de confirmación';
$string['confirmmailsubject_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante.';
$string['confirmusers'] = 'Solicitudes de matrícula';
$string['confirmusers_desc'] = 'Las filas en gris están en lista de espera.';
$string['coursename'] = 'Curso';
$string['custom_label'] = 'Etiqueta personalizada';
$string['defaultperiod'] = 'Duración por defecto de la matrícula';
$string['defaultperiod_desc'] = 'Tiempo por defecto durante el que la matrícula es válida. Si es cero, la duración es ilimitada.';
$string['defaultperiod_help'] = 'Tiempo por defecto durante el que la matrícula es válida, desde el momento en que se matricula al usuario. Si está desactivado, la duración es ilimitada.';
$string['editdescription'] = 'Texto sobre el botón de solicitud';
$string['enrolname'] = 'Matriculación con aprobación';
$string['enrolperiod'] = 'Duración de la matrícula';
$string['enrolperiod_desc'] = 'Tiempo por defecto durante el que la matrícula es válida. Si es cero, la duración es ilimitada.';
$string['enrolperiod_help'] = 'Tiempo durante el que la matrícula es válida, desde el momento en que se matricula al usuario. Si está desactivado, la duración es ilimitada.';
$string['enrolusers'] = 'Matricular usuarios';
$string['expiredaction'] = 'Acción al vencer la matrícula';
$string['expiredaction_help'] = 'Qué hacer cuando vence la matrícula de un usuario. Algunos datos y ajustes del usuario se eliminan del curso al darlo de baja.';
$string['expiry_desc'] = '';
$string['expiry_heading'] = 'Vencimiento';
$string['expirymessageenrolledbody'] = 'Hola {$a->user}:

Tu matrícula en el curso \'{$a->course}\' vence el {$a->timeend}.

Si necesitas ayuda, escribe a {$a->enroller}.';
$string['expirymessageenrolledsubject'] = 'Aviso de vencimiento de tu matrícula';
$string['expirymessageenrollerbody'] = 'Las matrículas en el curso \'{$a->course}\' de los siguientes usuarios vencen en {$a->threshold}:

    {$a->users}

Para extenderlas, ve a {$a->extendurl}';
$string['expirymessageenrollersubject'] = 'Aviso de vencimiento de matrículas';
$string['expirynotifyall'] = 'Profesor y usuario matriculado';
$string['expirynotifyenroller'] = 'Solo el profesor';
$string['group'] = 'Asignación de grupos';
$string['group_help'] = 'Puedes asignar ninguno o varios grupos.';
$string['mailtoteacher_suject'] = 'Nueva solicitud para unirse a un curso';
$string['maxenrolled'] = 'Máximo de usuarios matriculados';
$string['maxenrolled_help'] = 'Número máximo de usuarios que pueden matricularse. 0 significa sin límite.';
$string['maxenrolled_tip_1'] = 'de';
$string['maxenrolled_tip_2'] = 'plazas ya ocupadas.';
$string['maxenrolledreached_left'] = 'Ya se alcanzó el máximo de usuarios permitido';
$string['maxenrolledreached_right'] = '.';
$string['messageprovider:application'] = 'Solicitudes nuevas para unirse a un curso';
$string['messageprovider:cancelation'] = 'Rechazo de una solicitud para unirse a un curso';
$string['messageprovider:confirmation'] = 'Confirmación de una solicitud para unirse a un curso';
$string['messageprovider:expiry_notification'] = 'Avisos de vencimiento de la matriculación con aprobación';
$string['messageprovider:waitinglist'] = 'Solicitud para unirse a un curso en lista de espera';
$string['newapplicationnotification'] = 'Hay una solicitud nueva para unirse a un curso esperando revisión.';
$string['newenrols'] = 'Permitir solicitudes nuevas';
$string['notification'] = '<b>Solicitud enviada.</b> Te avisaremos por correo cuando esté confirmada.';
$string['notify_desc'] = 'Quién recibe un aviso cuando llega una solicitud nueva.';
$string['notify_heading'] = 'Notificaciones';
$string['notifycoursebased'] = 'Aviso de solicitud nueva (por curso, p. ej. profesores del curso)';
$string['notifycoursebased_desc'] = 'Por defecto en los métodos nuevos: avisar a todos los que pueden gestionar solicitudes en ese curso (p. ej. profesores y gestores).';
$string['notifyglobal'] = 'Aviso de solicitud nueva (global, p. ej. gestores y administradores del sitio)';
$string['notifyglobal_desc'] = 'Quién recibe un aviso de las solicitudes nuevas de cualquier curso.';
$string['opt_commentaryzone'] = 'Campo de comentario';
$string['opt_commentaryzone_help'] = 'Sí: muestra un campo de comentario en la solicitud.';
$string['pluginname'] = 'Matriculación con aprobación';
$string['pluginname_desc'] = 'Con este plugin las personas solicitan acceso a un curso, y un gestor del sitio o un profesor lo confirma antes de matricularlas.';
$string['privacy:metadata'] = 'El plugin Matriculación con aprobación no guarda datos personales.';
$string['profileoption'] = 'Campo del perfil que se muestra en la tabla';
$string['requestaccess'] = 'Solicitar acceso';
$string['requestintro'] = 'La admisión a este curso es por postulación. Solicita acceso y te avisaremos por correo cuando esté confirmado.';
$string['sendexpirynotificationstask'] = 'Enviar avisos de vencimiento de la matriculación con aprobación';
$string['show_extra_user_profile'] = 'Mostrar los campos adicionales del perfil en la solicitud';
$string['show_standard_user_profile'] = 'Mostrar los campos estándar del perfil en la solicitud';
$string['status'] = 'Permitir la matriculación con aprobación';
$string['status_desc'] = 'Permitir el acceso al curso a los usuarios matriculados internamente.';
$string['submitted_info'] = 'Información de la solicitud';
$string['user_profile'] = 'Perfil del usuario';
$string['waitinglist_defaultcontent'] = '<p>Hola, {firstname}:</p><p>Tu solicitud para unirte a <a href="{courseurl}">{content}</a> está en lista de espera. Te escribiremos si se libera un lugar.</p>';
$string['waitinglist_defaultsubject'] = 'Tu solicitud para {$a} está en lista de espera';
$string['waitmail_desc'] = '';
$string['waitmail_heading'] = 'Correo de lista de espera';
$string['waitmailcontent'] = 'Contenido del correo de lista de espera';
$string['waitmailcontent_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante. Marcas que se reemplazan con datos de Moodle: {firstname}, {lastname}, {username}, {content} (el nombre del curso), {courseurl} (el enlace al curso).';
$string['waitmailsubject'] = 'Asunto del correo de lista de espera';
$string['waitmailsubject_desc'] = 'Déjalo vacío para usar el texto por defecto, en el idioma de cada estudiante.';
