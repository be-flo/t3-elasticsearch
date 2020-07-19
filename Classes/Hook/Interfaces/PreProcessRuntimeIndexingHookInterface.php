<?php


namespace BeFlo\T3Elasticsearch\Hook\Interfaces;


use BeFlo\T3Elasticsearch\Domain\Dto\IndexData;
use BeFlo\T3Elasticsearch\Index\Index;

interface PreProcessRuntimeIndexingHookInterface
{

    /**
     * @param IndexData $indexData
     * @param Index     $index
     */
    public function preProcessRuntimeIndexing(IndexData $indexData, Index $index): void;
}