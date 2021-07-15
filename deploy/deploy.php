<?php

namespace Deployer;

use function Symfony\Component\Translation\t;

require 'recipe/common.php';

// Project name
set('application', 'otus_course');

// Project repository
set('repository', 'https://Snezhig@bitbucket.org/Snezhig/course.project.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['.data', 'storage']);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('82.146.34.101')
    ->user('otus')
    ->configFile('/.ssh/config')
    ->identityFile('/.ssh/otus.course')
    ->set('deploy_path', '~/{{application}}');

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:env',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:data_dir',
    'deploy:docker',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

task('deploy:vendors', function () {
    run('cd {{release_path}}');
});
task('deploy:env', function(){
   run('cd {{release_path}} && mv ./deploy/.env.template .env');
});
task('deploy:docker', function(){
   run('cd {{release_path}} && docker-compose run php composer install');
   run('cd {{release_path}} && docker-compose run php php artisan key:generate');
});

task('deploy:data_dir', function () {
    run('mkdir -p ~/{{application}}/shared/.data/.db');
    run('mkdir -p ~/{{application}}/shared/.data/.grafana');
    run('mkdir -p ~/{{application}}/shared/.data/.prometheus');
    run('mkdir -p ~/{{application}}/shared/.data/.redis');
});


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');

