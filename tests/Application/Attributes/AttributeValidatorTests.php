<?php

require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class AttributeValidatorTests extends TestBase
{
	public function testChecksAttributesAgainstService()
	{
		$service = $this->createMock('IAttributeService');
		$category = CustomAttributeCategory::RESOURCE;
		$attributes = array('abc');
		$entityId = 123;

		$errors = array('error1', 'error2');

		$serviceResult = new AttributeServiceValidationResult(false, $errors);

		$service->expects($this->once())
				->method('Validate')
				->with($this->equalTo($category), $this->equalTo($attributes), $this->equalTo($entityId))
				->will($this->returnValue($serviceResult));

		$validator = new AttributeValidator($service, $category, $attributes, $entityId);
		$validator->Validate();

		$this->assertFalse($validator->IsValid());
		$this->assertEquals($errors, $validator->Messages());

	}
}
?>
