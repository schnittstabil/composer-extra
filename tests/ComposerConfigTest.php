<?php

namespace Schnittstabil\ComposerExtra;

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
}
