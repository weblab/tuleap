<?php
/**
 * Copyright (c) Enalean, 2014. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'pre.php';
require_once __DIR__.'/../include/autoload.php';

$file_importer = new Tuleap\ProFTPd\Xferlog\FileImporter(
    new Tuleap\ProFTPd\Xferlog\Dao(),
    new Tuleap\ProFTPd\Xferlog\Parser(),
    UserManager::instance(),
    ProjectManager::instance()
);

$file_importer->import($argv[1]);

echo "{$file_importer->getNbImportedLines()} lines imported".PHP_EOL;
$errors    = $file_importer->getErrors();
$nb_errors = count($errors);
if ($nb_errors) {
    $logger = new BackendLogger();
    echo "$nb_errors errors".PHP_EOL;
    foreach ($errors as $error) {
        $logger->error('[Proftpd][xferlog parse] '.$error);
        echo "*** ERROR: ".$error.PHP_EOL;
    }
}