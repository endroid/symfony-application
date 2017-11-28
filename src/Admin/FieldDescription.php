<?php

namespace App\Admin;

use Doctrine\Common\Inflector\Inflector;
use Sonata\AdminBundle\Exception\NoValueException;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription as BaseFieldDescription;

class FieldDescription extends BaseFieldDescription
{
    /**
     * {@inheritdoc}
     */
    public function getFieldValue($object, $fieldName)
    {
        if ($this->isVirtual()) {
            return;
        }

        $camelizedFieldName = Inflector::classify($fieldName);

        $getters = [];
        $parameters = [];

        // prefer method name given in the code option
        if ($this->getOption('code')) {
            $getters[] = $this->getOption('code');
        }
        // parameters for the method given in the code option
        if ($this->getOption('parameters')) {
            $parameters = $this->getOption('parameters');
        }
        $getters[] = 'get'.$camelizedFieldName;
        $getters[] = 'is'.$camelizedFieldName;
        $getters[] = 'has'.$camelizedFieldName;

        foreach ($getters as $getter) {
            if (method_exists($object, $getter)) {
                return call_user_func_array([$object, $getter], $parameters);
            }
        }

        if (method_exists($object, '__call')) {
            return call_user_func_array([$object, '__call'], [$fieldName, $parameters]);
        }

        if (isset($object->{$fieldName})) {
            return $object->{$fieldName};
        }

        if (method_exists($object, '__get')) {
            return call_user_func_array([$object, '__get'], [$fieldName]);
        }

        throw new NoValueException(sprintf('Unable to retrieve the value of `%s`', $this->getName()));
    }
}
