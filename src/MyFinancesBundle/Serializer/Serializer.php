<?php

namespace MyFinancesBundle\Serializer;

use Symfony\Component\Serializer\Serializer as SymfonySerializer;

class Serializer
{
    /**
     * @const string
     */
    const JSON = 'json';

    /**
     * @param array $normalizers
     * @param array $encoders
     */
    public function __construct(array $normalizers, array $encoders)
    {
        $this->normalizers = $normalizers;
        $this->encoders    = $encoders;
    }

    /**
     * @return SymfonySerializer
     */
    public function getSerializer()
    {
        return new SymfonySerializer(array_map([$this, 'toCreate'], $this->normalizers), array_map([$this, 'toCreate'], $this->encoders));
    }

    /**
     * @param mixed $results
     *
     * @return array
     */
    public function toArray($results)
    {
        $toArray = [];

        if (is_array($results)) {
            foreach ($results as $result) {
                $toArray[] = $this->jsonDecode($result);
            }
        } else {
            $toArray = $this->jsonDecode($result);
        }

        return $toArray;
    }

    /**
     * @param mixed $result
     *
     * @return array
     */
    private function jsonDecode($result)
    {
        return json_decode($this->getSerializer()->serialize($result, self::JSON));
    }

    /**
     * @param string $className
     *
     * @return mixed
     */
    private function toCreate($className)
    {
        return new $className();
    }
}
