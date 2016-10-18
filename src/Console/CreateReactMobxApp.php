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

        $sourcePath = $this->option('source-path') ?: resource_path('assets/js/'.snake_case($appName).'/');;

        $outputPath = $this->option('output-path') ?: public_path('js/'.snake_case($appName).'/');

        $this->copyDir(__DIR__.'/../Boilerplate/Static/', $sourcePath);

        $packageDotJson = str_replace(
            '{{ NAME }}',
            $appName,
            file_get_contents(__DIR__.'/../Boilerplate/Templates/package.json.txt')
        );

        file_put_contents($sourcePath.'package.json', $packageDotJson);


        $webpackConfig = str_replace(
            ['{{ PATH }}', '{{ FILENAME }}'],
            [$outputPath, snake_case($appName).'.js'],
            file_get_contents(__DIR__.'/../Boilerplate/Templates/webpack.config.js.txt')
        );

        file_put_contents($sourcePath.'webpack.config.js', $webpackConfig);

        $this->info('Done!');

    }

    protected function copyDir($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}
