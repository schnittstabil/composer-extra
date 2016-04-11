<?php

namespace Schnittstabil\ComposerExtra;

/**
 * schnittstabil/sugared-phpunit depends on composer-extra,
 * thus we need to run tests in seperate processes with new global state
 * to gather code coverage informations of this composer-extra library,
 * and not the already loaded (global) schnittstabil/sugared-phpunit one.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ComposerExtraTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigWithDisabledPresetsInComposerJson()
    {
        $sut = new ComposerExtra(
            'disable presets',
            [
                'presets' => [
                    'Schnittstabil\ComposerExtra\Presets\DefaultPreset::get',
                ],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('defaultPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWODefaults()
    {
        $sut = new ComposerExtra('disable presets', null, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertFalse($sut->get('default', false));
        $this->assertFalse($sut->get('defaultPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWithEmptyPresets()
    {
        $sut = new ComposerExtra(
            'empty presets',
            [
                'presets' => [],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('defaultPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWithPresets()
    {
        $sut = new ComposerExtra(
            'schnittstabil/composer-extra',
            [
                'presets' => [
                    'Schnittstabil\ComposerExtra\Presets\DefaultPreset::get',
                ],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('#000', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('defaultPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWithMultiplePresets()
    {
        $sut = new ComposerExtra(
            'multiple presets',
            [
                'presets' => [
                    'Schnittstabil\ComposerExtra\Presets\DefaultPreset::get',
                    'Schnittstabil\ComposerExtra\Presets\ExtendedPreset::get',
                ],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('rainbow', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('defaultPreset'));
        $this->assertTrue($sut->get('extendedPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWithOverridePresets()
    {
        $sut = new ComposerExtra(
            'override presets',
            [
                'presets' => [
                    'Schnittstabil\ComposerExtra\Presets\DefaultPreset::get',
                ],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(['Schnittstabil\ComposerExtra\Presets\ExtendedPreset::get'], $sut->get('presets'));
        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('rainbow', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('defaultPreset', false));
        $this->assertTrue($sut->get('extendedPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()['composerJson']);
    }

    public function testGetConfigWithoutComposerEntry()
    {
        $sut = new ComposerExtra(
            uniqid(),
            [
                'presets' => [
                    'Schnittstabil\ComposerExtra\Presets\DefaultPreset::get',
                ],
                'unicorns' => 0,
                'default' => true,
            ],
            'presets'
        );

        $this->assertEquals(['Schnittstabil\ComposerExtra\Presets\DefaultPreset::get'], $sut->get('presets'));
        $this->assertEquals(0, $sut->get('unicorns'));
        $this->assertEquals('#000', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('defaultPreset'));
        $this->assertFalse($sut->get('extendedPreset', false));
        $this->assertFalse($sut->get('composerJson', false));
    }
}
