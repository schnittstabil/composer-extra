<?php

namespace Schnittstabil\ComposerExtra;

class ComposerExtraTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigWithDisabledPresetsInComposerJson()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('disable presets', $defaults, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('firstPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWODefaults()
    {
        $sut = new ComposerExtra('disable presets', null, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertFalse($sut->get('default', false));
        $this->assertFalse($sut->get('firstPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithEmptyPresets()
    {
        $defaults = new \stdClass();
        $defaults->presets = [];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('empty presets', $defaults, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('firstPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithNoPresetsPath()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('schnittstabil/composer-extra', $defaults);

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals(null, $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('firstPreset', false));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithPresets()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('schnittstabil/composer-extra', $defaults, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('#000', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('firstPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithMultiplePresets()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
            'Schnittstabil\ComposerExtra\Presets\SecondPreset::get',
            'Schnittstabil\ComposerExtra\Presets\ThirdPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('multiple presets', $defaults, 'presets');

        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('rainbow', $sut->get('color'));
        $this->assertEquals('ThirdPreset', $sut->get('name'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('firstPreset'));
        $this->assertTrue($sut->get('secondPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithOverridePresets()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra('override presets', $defaults, 'presets');

        $this->assertEquals(['Schnittstabil\ComposerExtra\Presets\SecondPreset::get'], $sut->get('presets'));
        $this->assertEquals(42, $sut->get('unicorns'));
        $this->assertEquals('rainbow', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertFalse($sut->get('firstPreset', false));
        $this->assertTrue($sut->get('secondPreset'));
        $this->assertTrue($sut->get('composerJson'));
        $this->assertTrue($sut->get()->composerJson);
    }

    public function testGetConfigWithoutComposerEntry()
    {
        $defaults = new \stdClass();
        $defaults->presets = [
            'Schnittstabil\ComposerExtra\Presets\FirstPreset::get',
        ];
        $defaults->unicorns = 0;
        $defaults->default = true;

        $sut = new ComposerExtra(uniqid(), $defaults, 'presets');

        $this->assertEquals(['Schnittstabil\ComposerExtra\Presets\FirstPreset::get'], $sut->get('presets'));
        $this->assertEquals(0, $sut->get('unicorns'));
        $this->assertEquals('#000', $sut->get('color'));
        $this->assertTrue($sut->getOrFail('default'));
        $this->assertTrue($sut->get('firstPreset'));
        $this->assertFalse($sut->get('secondPreset', false));
        $this->assertFalse($sut->get('composerJson', false));
    }
}
