<?php

namespace LmcUserTest\Form;

use LmcUser\Form\Register as Form;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @dataProvider providerTestConstruct
     */
    public function testConstruct($useCaptcha = false)
    {
        $options = $this->createMock('LmcUser\Options\RegistrationOptionsInterface');
        $options->expects($this->once())
            ->method('getEnableUsername')
            ->willReturn(false);
        $options->expects($this->once())
            ->method('getEnableDisplayName')
            ->willReturn(false);
        $options->expects($this->any())
            ->method('getUseRegistrationFormCaptcha')
            ->willReturn($useCaptcha);
        if ($useCaptcha && class_exists('\Laminas\Captcha\AbstractAdapter')) {
            $captcha = $this->getMockForAbstractClass('\Laminas\Captcha\AbstractAdapter');

            $options->expects($this->once())
                ->method('getFormCaptchaOptions')
                ->willReturn($captcha);
        }

        $form = new Form(null, $options);

        $elements = $form->getElements();

        $this->assertArrayNotHasKey('userId', $elements);
        $this->assertArrayNotHasKey('username', $elements);
        $this->assertArrayNotHasKey('display_name', $elements);
        $this->assertArrayHasKey('email', $elements);
        $this->assertArrayHasKey('password', $elements);
        $this->assertArrayHasKey('passwordVerify', $elements);
    }

    public function providerTestConstruct()
    {
        return array(
            array(true),
            array(false)
        );
    }

    public function testSetGetRegistrationOptions()
    {
        $options = $this->createMock('LmcUser\Options\RegistrationOptionsInterface');
        $options->expects($this->once())
            ->method('getEnableUsername')
            ->willReturn(false);
        $options->expects($this->once())
            ->method('getEnableDisplayName')
            ->willReturn(false);
        $options->expects($this->any())
            ->method('getUseRegistrationFormCaptcha')
            ->willReturn(false);
        $form = new Form(null, $options);

        $this->assertSame($options, $form->getRegistrationOptions());

        $optionsNew = $this->createMock('LmcUser\Options\RegistrationOptionsInterface');
        $form->setRegistrationOptions($optionsNew);
        $this->assertSame($optionsNew, $form->getRegistrationOptions());
    }

    public function testSetCaptchaElement()
    {
        $options = $this->createMock('LmcUser\Options\RegistrationOptionsInterface');
        $options->expects($this->once())
            ->method('getEnableUsername')
            ->willReturn(false);
        $options->expects($this->once())
            ->method('getEnableDisplayName')
            ->willReturn(false);
        $options->expects($this->any())
            ->method('getUseRegistrationFormCaptcha')
            ->willReturn(false);

        $captcha = $this->createMock('\Laminas\Form\Element\Captcha');
        $form = new Form(null, $options);

        $form->setCaptchaElement($captcha);

        $reflection = $this->helperMakePropertyAccessable($form, 'captchaElement');
        $this->assertSame($captcha, $reflection->getValue($form));
    }


    /**
     *
     * @param  mixed  $objectOrClass
     * @param  string $property
     * @param  mixed  $value         = null
     * @return \ReflectionProperty
     */
    public function helperMakePropertyAccessable($objectOrClass, $property, $value = null)
    {
        $reflectionProperty = new \ReflectionProperty($objectOrClass, $property);
        $reflectionProperty->setAccessible(true);

        if ($value !== null) {
            $reflectionProperty->setValue($objectOrClass, $value);
        }
        return $reflectionProperty;
    }
}
