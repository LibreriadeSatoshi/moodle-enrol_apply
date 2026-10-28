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

$string['applicationcancelednotification'] = 'Sua solicitação para entrar no curso não foi aceita.';
$string['applicationconfirmednotification'] = 'Sua solicitação para entrar no curso foi confirmada.';
$string['applicationdeferrednotification'] = 'Sua solicitação para entrar no curso está na lista de espera.';
$string['apply:config'] = 'Configurar a inscrição com aprovação';
$string['apply:manage'] = 'Gerenciar inscrições de usuários';
$string['apply:manageapplications'] = 'Gerenciar solicitações de inscrição';
$string['apply:unenrol'] = 'Cancelar a inscrição de usuários no curso';
$string['apply:unenrolself'] = 'Cancelar a própria inscrição no curso';
$string['applycomment'] = 'Comentário';
$string['applydate'] = 'Solicitado em';
$string['applymanage'] = 'Gerenciar solicitações de inscrição';
$string['applyuser'] = 'Nome';
$string['applyusermail'] = 'E-mail';
$string['btncancel'] = 'Recusar solicitações';
$string['btnconfirm'] = 'Confirmar solicitações';
$string['btnwait'] = 'Mover para a lista de espera';
$string['cancelation_defaultcontent'] = '<p>Olá, {firstname}.</p><p>Desta vez sua solicitação para entrar em {content} não foi aceita.</p>';
$string['cancelation_defaultsubject'] = 'Sua solicitação para {$a} não foi aceita';
$string['cancelmail_desc'] = '';
$string['cancelmail_heading'] = 'E-mail de recusa';
$string['cancelmailcontent'] = 'Conteúdo do e-mail de recusa';
$string['cancelmailcontent_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante. Marcas substituídas por dados do Moodle: {firstname}, {lastname}, {username}, {content} (o nome do curso), {courseurl} (o link do curso).';
$string['cancelmailsubject'] = 'Assunto do e-mail de recusa';
$string['cancelmailsubject_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante.';
$string['cantenrol'] = 'A inscrição está desativada ou inativa';
$string['comment'] = 'Comentário';
$string['commentrequired'] = 'Sim, obrigatório';
$string['confirmation_defaultcontent'] = '<p>Olá, {firstname}.</p><p>Sua solicitação foi confirmada: você já está inscrito em <a href="{courseurl}">{content}</a>. Você também vai encontrá-lo em Meus cursos.</p>';
$string['confirmation_defaultsubject'] = 'Você está inscrito em {$a}';
$string['confirmenrol'] = 'Gerenciar solicitações';
$string['confirmmail_desc'] = '';
$string['confirmmail_heading'] = 'E-mail de confirmação';
$string['confirmmailcontent'] = 'Conteúdo do e-mail de confirmação';
$string['confirmmailcontent_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante. Marcas substituídas por dados do Moodle: {firstname}, {lastname}, {username}, {content} (o nome do curso), {courseurl} (o link do curso), {timeend} (a data de fim da inscrição).';
$string['confirmmailsubject'] = 'Assunto do e-mail de confirmação';
$string['confirmmailsubject_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante.';
$string['confirmusers'] = 'Solicitações de inscrição';
$string['confirmusers_desc'] = 'As linhas em cinza estão na lista de espera.';
$string['coursename'] = 'Curso';
$string['custom_label'] = 'Rótulo personalizado';
$string['defaultperiod'] = 'Duração padrão da inscrição';
$string['defaultperiod_desc'] = 'Tempo padrão durante o qual a inscrição é válida. Se for zero, a duração é ilimitada.';
$string['defaultperiod_help'] = 'Tempo padrão durante o qual a inscrição é válida, a partir do momento em que o usuário é inscrito. Se estiver desativado, a duração é ilimitada.';
$string['editdescription'] = 'Texto acima do botão de solicitação';
$string['enrolname'] = 'Inscrição com aprovação';
$string['enrolperiod'] = 'Duração da inscrição';
$string['enrolperiod_desc'] = 'Tempo padrão durante o qual a inscrição é válida. Se for zero, a duração é ilimitada.';
$string['enrolperiod_help'] = 'Tempo durante o qual a inscrição é válida, a partir do momento em que o usuário é inscrito. Se estiver desativado, a duração é ilimitada.';
$string['enrolusers'] = 'Inscrever usuários';
$string['expiredaction'] = 'Ação ao vencer a inscrição';
$string['expiredaction_help'] = 'O que fazer quando a inscrição de um usuário vence. Alguns dados e configurações do usuário são removidos do curso ao cancelar a inscrição.';
$string['expiry_desc'] = '';
$string['expiry_heading'] = 'Vencimento';
$string['expirymessageenrolledbody'] = 'Olá, {$a->user}.

Sua inscrição no curso \'{$a->course}\' vence em {$a->timeend}.

Se precisar de ajuda, escreva para {$a->enroller}.';
$string['expirymessageenrolledsubject'] = 'Aviso de vencimento da sua inscrição';
$string['expirymessageenrollerbody'] = 'As inscrições no curso \'{$a->course}\' dos seguintes usuários vencem em {$a->threshold}:

    {$a->users}

Para estendê-las, acesse {$a->extendurl}';
$string['expirymessageenrollersubject'] = 'Aviso de vencimento de inscrições';
$string['expirynotifyall'] = 'Professor e usuário inscrito';
$string['expirynotifyenroller'] = 'Só o professor';
$string['group'] = 'Atribuição de grupos';
$string['group_help'] = 'Você pode atribuir nenhum ou vários grupos.';
$string['mailtoteacher_suject'] = 'Nova solicitação para entrar em um curso';
$string['maxenrolled'] = 'Máximo de usuários inscritos';
$string['maxenrolled_help'] = 'Número máximo de usuários que podem se inscrever. 0 significa sem limite.';
$string['maxenrolled_tip_1'] = 'de';
$string['maxenrolled_tip_2'] = 'vagas já ocupadas.';
$string['maxenrolledreached_left'] = 'O número máximo de usuários permitido';
$string['maxenrolledreached_right'] = 'já foi atingido.';
$string['messageprovider:application'] = 'Novas solicitações para entrar em um curso';
$string['messageprovider:cancelation'] = 'Recusa de uma solicitação para entrar em um curso';
$string['messageprovider:confirmation'] = 'Confirmação de uma solicitação para entrar em um curso';
$string['messageprovider:expiry_notification'] = 'Avisos de vencimento da inscrição com aprovação';
$string['messageprovider:waitinglist'] = 'Solicitação para entrar em um curso na lista de espera';
$string['newapplicationnotification'] = 'Há uma nova solicitação para entrar em um curso aguardando revisão.';
$string['newenrols'] = 'Permitir novas solicitações';
$string['notification'] = '<b>Solicitação enviada.</b> Avisaremos por e-mail quando ela for confirmada.';
$string['notify_desc'] = 'Quem recebe um aviso quando chega uma nova solicitação.';
$string['notify_heading'] = 'Notificações';
$string['notifycoursebased'] = 'Aviso de nova solicitação (por curso, ex. professores do curso)';
$string['notifycoursebased_desc'] = 'Padrão para novos métodos: avisar todos que podem gerenciar solicitações nesse curso (ex. professores e gestores).';
$string['notifyglobal'] = 'Aviso de nova solicitação (global, ex. gestores e administradores do site)';
$string['notifyglobal_desc'] = 'Quem recebe um aviso das novas solicitações de qualquer curso.';
$string['opt_commentaryzone'] = 'Campo de comentário';
$string['opt_commentaryzone_help'] = 'Sim: um campo de comentário na solicitação. Sim, obrigatório: não é possível enviar a solicitação com o campo vazio.';
$string['pluginname'] = 'Inscrição com aprovação';
$string['pluginname_desc'] = 'Com este plugin as pessoas solicitam acesso a um curso, e um gestor do site ou um professor confirma antes de inscrevê-las.';
$string['privacy:metadata'] = 'O plugin Inscrição com aprovação não guarda dados pessoais.';
$string['profileoption'] = 'Campo do perfil mostrado na tabela';
$string['requestaccess'] = 'Solicitar acesso';
$string['requestintro'] = 'A admissão neste curso é por candidatura. Solicite acesso e avisaremos por e-mail quando estiver confirmado.';
$string['sendexpirynotificationstask'] = 'Enviar avisos de vencimento da inscrição com aprovação';
$string['show_extra_user_profile'] = 'Mostrar os campos adicionais do perfil na solicitação';
$string['show_standard_user_profile'] = 'Mostrar os campos padrão do perfil na solicitação';
$string['status'] = 'Permitir a inscrição com aprovação';
$string['status_desc'] = 'Permitir o acesso ao curso aos usuários inscritos internamente.';
$string['submitted_info'] = 'Informações da solicitação';
$string['user_profile'] = 'Perfil do usuário';
$string['waitinglist_defaultcontent'] = '<p>Olá, {firstname}.</p><p>Sua solicitação para entrar em <a href="{courseurl}">{content}</a> está na lista de espera. Escreveremos se abrir uma vaga.</p>';
$string['waitinglist_defaultsubject'] = 'Sua solicitação para {$a} está na lista de espera';
$string['waitmail_desc'] = '';
$string['waitmail_heading'] = 'E-mail de lista de espera';
$string['waitmailcontent'] = 'Conteúdo do e-mail de lista de espera';
$string['waitmailcontent_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante. Marcas substituídas por dados do Moodle: {firstname}, {lastname}, {username}, {content} (o nome do curso), {courseurl} (o link do curso).';
$string['waitmailsubject'] = 'Assunto do e-mail de lista de espera';
$string['waitmailsubject_desc'] = 'Deixe vazio para usar o texto padrão, no idioma de cada estudante.';
