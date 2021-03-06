<?php
/**
 * This file is part of Project Chaplin.
 *
 * Project Chaplin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Project Chaplin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Project Chaplin. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   ProjectChaplin
 * @author    Dan Dart <chaplin@dandart.co.uk>
 * @copyright 2012-2018 Project Chaplin
 * @license   http://www.gnu.org/licenses/agpl-3.0.html GNU AGPL 3.0
 * @version   GIT: $Id$
 * @link      https://github.com/danwdart/projectchaplin
**/

namespace Chaplin\Dao\Smtp;

use Chaplin\Dao\DaoInterface;
use Chaplin\Model\User;
use Zend_Mail;
use Mustache_Engine;

class Exchange implements DaoInterface
{
    public function email(
        User $modelUser,
        $strSubject,
        $strTemplate,
        $arrParams
    ) {

        $strVhost = getenv("VHOST");

        $mail = new Zend_Mail();
        $mail->addTo($modelUser->getEmail(), $modelUser->getNick());
        $mail->setFrom('info@'.$strVhost, 'Project Chaplin');
        $mail->setSubject($strSubject);
        $strFilenameTemplateHTML = getenv("EMAILS_PATH").
            '/html/'.
            $strTemplate.
            '.mustache';
        $strFilenameTemplateText = getenv("EMAILS_PATH").
            '/text/'.
            $strTemplate.
            '.mustache';
        $strTemplateHTML = file_get_contents($strFilenameTemplateHTML);
        $strTemplateText = file_get_contents($strFilenameTemplateText);
        $m = new Mustache_Engine();
        $strHTML = $m->render($strTemplateHTML, $arrParams);
        $strText = $m->render($strTemplateText, $arrParams);
        $mail->setBodyText($strText);
        $mail->setBodyHtml($strHTML);
        $mail->send();
    }
}
