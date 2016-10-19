<?php

namespace DamianTW\LaravelReactMobxGenerator\Console;

use Illuminate\Console\Command;

class CreateReactMobxApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:react-mobx {appName} {--source-path=} {--output-path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new react + mobx micro application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $appName = $this->argument('appName');

        $sourcePath = $this->option('source-path') ?: resource_path('assets/js/'.str_slug($appName).'/');;

        $outputPath = $this->option('output-path') ?: public_path('js/');

        $this->copyDir(__DIR__.'/../Boilerplate/Static/', $sourcePath);

        $packageDotJson = str_replace(
            '{{ NAME }}',
            $appName,
            file_get_contents(__DIR__.'/../Boilerplate/Templates/package.json.txt')
        );

        file_put_contents($sourcePath.'package.json', $packageDotJson);

        $webpackConfigs = str_replace(
            ['{{ PATH }}', '{{ FILENAME }}'],
            [$outputPath, str_slug($appName).'.js'],
            [
                file_get_contents(__DIR__.'/../Boilerplate/Templates/webpack.config.js.txt'),
                file_get_contents(__DIR__.'/../Boilerplate/Templates/webpack.production.config.js.txt')
            ]
        );

        file_put_contents($sourcePath.'webpack.config.js', $webpackConfigs[0]);
        file_put_contents($sourcePath.'webpack.production.config.js', $webpackConfigs[1]);

        $this->info('Done!');

    }

    protected function copyDir($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->copyDir($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}
