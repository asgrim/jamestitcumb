---
title: ZF2 + Doctrine ObjectSelect + Form binding + Custom Select Options
tags: [php, doctrine, zf, zend-form]
---
This morning me and another developer have spent 3.5 hours figuring out how on earth to solve our problem. We are writing a [Zend Framework 2](http://framework.zend.com/) application that uses Doctrine entities. The trouble was figuring out how to use the `$form->bind(..)` method with our Doctrine entities. Turns out, a combination of RTFM and sifting through the code for Doctrine, what we were trying to do _is_ possible without nasty hacks. In the examples below, the `AdVariant` entity is the entity we are creating the edit form for, and in our application's vernacular, a "module" is a semantic "grouping" of pages - it does not mean a ZF2 "Module"!

**Step 1 - Hydration**

First, we need to use Doctrine's built in [Hydrator](https://github.com/doctrine/DoctrineModule/blob/master/docs/hydrator.md) ([what is a hydrator?](http://framework.zend.com/manual/2.0/en/modules/zend.stdlib.hydrator.html)) in our form:

~~~ .php
<?php
namespace Ed\Advertisers\Form;
 
// .. more use
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
 
class AdVariantForm extends Form implements InputFilterProviderInterface
{
	protected $entityManager;
	protected $moduleService;
	protected $pageService;
 
	public function __construct(EntityManager $entityManager, ModuleService $moduleService, PageService $pageService, $name = null)
	{
		parent::__construct($name);
 
		$hydrator = new DoctrineHydrator($entityManager, '\Ed\Advertisers\Entity\AdVariant');
		$this->setHydrator($hydrator);
 
		// ... set up elements here
	}
}
~~~

The `DoctrineHydrator` basically tells `Zend\Form`:
	
  * ... how to populate the form when given an entity (extract)
  * ... how to populate an entity when given a form (hydrate)

So in the code snippet, we create the `DoctrineHydrator`, give it the object manager and tell it what Entity we are using for hydration.

**Step 2 - Bind Entity to Form**

This is pretty much as per the example given in the Doctrine Hydrator documentation above:

~~~ .php
public function editAction()
{
	// .. create the form
	// .. load $adVariant from query string params
 
	$form->bind($adVariant);
 
	if ($this->getRequest()->isPost())
	{
		$form->setData($this->getRequest()->getPost());
 
		if ($form->isValid())
		{
			$this->adVariantService->getEntityManager()->persist($adVariant);
			$this->adVariantService->getEntityManager()->flush();
 
			// .. redirect or whatever else
		}
	}
 
	// .. other stuff
}
~~~

Previously, we were populating the form using:

~~~ .php
$form->setData($entity->getArrayCopy())
~~~

and then populating the entity by fetching values from the validated form and using the entity's setters, which was pretty ugly:

~~~ .php
$adGroupId = $form->get('adGroupId')->getValue();
$adGroup = $this->adGroupService->fetchById($adGroupId);
 
// .. fetch other entities in this awful way
 
$name = $form->get('name')->getValue();
// .. other entitites
 
// .. using lots of setters to populate!!
$adVariant->setName($name);
$adVariant->setAdGroup($adGroup);
$adVariant->setWebsite($website);
$adVariant->setProduct($product);
$adVariant->setBusiness($business);
$adVariant->setLandingPage($landingPage);
$adVariant->setTargetedLandingPage($targetedLandingPage);
$adVariant->setTrackingCode($trackingCode);
$adVariant->setCostType($costType);
$adVariant->setUnitCost($unitCost);
$adVariant->setStatus($status);
$adVariant->setDateUpdated(new \DateTime());
~~~

**Step 3 - Using Doctrine ObjectSelect**

Instead of using ZF2's Select element, we should use Doctrine's `ObjectSelect` from its [form element collection](https://github.com/doctrine/DoctrineModule/blob/master/docs/form-element.md), which works with a "Proxy" object. The [ObjectSelect](https://github.com/doctrine/DoctrineModule/blob/master/src/DoctrineModule/Form/Element/ObjectSelect.php) itself is pretty straightforward. Here's how to use it:

~~~ .php
$adGroup = new ObjectSelect('adGroup');
$adGroup->setEmptyOption('Select..');
$adGroup->setOptions(array(
	'object_manager' => $this->entityManager,
	'target_class' => '\Ed\Advertisers\Entity\AdGroup',
	'property' => 'name',
	'is_method' => true,
	'find_method' => array(
		'name' => 'findBy',
		'params' => array(
			'criteria' => array('status' => 'ACTIVE'),
		),
	),
));
~~~

This uses the repository's `findBy()` method to find all Ad Groups with a status of "ACTIVE".

**Step 4 - Custom options**

After examining the `ObjectSelect` class, it seems we can provide our own options (for example, we wanted to have `<optgroup>` groups on one of our dropdowns):

~~~ .php
// .. build $optionValues, e.g.:
// $optionValues = array(
//   0 => array(
//     'label' => 'MyModule1',
//     'options' => array(
//       1 => 'page1',
//       2 => 'page2',
//       3 => 'page3',
//     ),
//   ),
//   1 => array(
//     'label' => 'MyModule2',
//     'options' => array(
//       4 => 'page1',
//       5 => 'page2',
//       6 => 'page3',
//     ),
//   ),
// );
$landingPage = new ObjectSelect('landingPage');
$landingPage->setEmptyOption('Select..');
$landingPage->setOptions(array(
	'object_manager' => $this->entityManager,
	'target_class' => '\Ed\Advertisers\Entity\AdGroup',
));
$landingPage->setValueOptions($optionValues);
~~~

This works because in the `ObjectSelect->getValueOptions()` method only calls the proxy method if the `$this->valueOptions` is NOT empty:

~~~ .php
public function getValueOptions()
{
    if (empty($this->valueOptions)) { // this won't be empty because we have called setValueOptions in our form
        $this->setValueOptions($this->getProxy()->getValueOptions());
    }
    return $this->valueOptions;
}
~~~

Huzzah! Things now work :)
