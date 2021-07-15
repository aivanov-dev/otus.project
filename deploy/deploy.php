<?php

namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'otus_course');

// Project repository
set('repository', getenv('BITBUCKET_GIT_HTTP_ORIGIN'));
//set('repository', 'https://Snezhig@bitbucket.org/Snezhig/course.project.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('82.146.34.101')
    ->set('branch', 'feature/pipeline')
    ->user('otus')
//    ->configFile('/.ssh/config')
//    ->identityFile('/.ssh/otus.course')
    ->set('deploy_path', '~/{{application}}');

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:data_dir',
    'deploy:writable',
    'deploy:env',
    'deploy:vendors',
    'deploy:composer',
    'artisan:key',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

task('deploy:composer', 'cd {{release_path}} && composer install');
task('artisan:key', 'cd {{release_path}} && php artisan key:generate');

task('deploy:env', function () {
    within('{{release_path}}', function () {
        run('cp ./deploy/.env.template .env');
        run("sed -i -- \"s|@DB_DATABASE@|" . getenv('DB_DATABASE') . "|g\" .env");
        run("sed -i -- \"s|@DB_USERNAME@|" . getenv('DB_USERNAME') . "|g\" .env");
        run("sed -i -- \"s|@DB_HOST@|" . getenv('DB_HOST') . "|g\" .env");
        run("sed -i -- \"s|@DB_PASSWORD@|" . getenv('DB_PASSWORD') . "|g\" .env");
    });
});

task('deploy:data_dir', function () {
    run('mkdir -p ~/{{application}}/shared/.data/.grafana');
    run('mkdir -p ~/{{application}}/shared/.data/.prometheus');
    run('mkdir -p ~/{{application}}/shared/.data/.redis');
});


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


// Migrate database before symlink new release.
//before('deploy:symlink', 'artisan:migrate');

