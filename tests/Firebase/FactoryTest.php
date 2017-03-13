<?php

namespace Tests\Firebase;

use Firebase\Factory;
use Firebase\V3\Firebase;
use Google\Auth\CredentialsLoader;
use Tests\FirebaseTestCase;

class FactoryTest extends FirebaseTestCase
{
    /**
     * @var string
     */
    private $keyFile;

    protected function setUp()
    {
        $this->keyFile = $this->fixturesDir.'/ServiceAccount/valid.json';

        // Unset all eligible environment variables
        putenv(Factory::ENV_VAR);
        putenv(CredentialsLoader::ENV_VAR);
        putenv(
            'HOME'
            .DIRECTORY_SEPARATOR
            .CredentialsLoader::NON_WINDOWS_WELL_KNOWN_PATH_BASE
            .DIRECTORY_SEPARATOR
            .CredentialsLoader::WELL_KNOWN_PATH
        );
    }

    public function testItFindsCredentialsFromTheFirebaseEnvVar()
    {
        putenv(sprintf('%s=%s', Factory::ENV_VAR, $this->keyFile));

        $this->assertInstanceOf(Firebase::class, (new Factory())->create());
    }

    public function testItFindsCredentialsFromTheGoogleApplicationCredentialsEnvVar()
    {
        putenv(sprintf('%s=%s', CredentialsLoader::ENV_VAR, $this->keyFile));

        $this->assertInstanceOf(Firebase::class, (new Factory())->create());
    }
}
