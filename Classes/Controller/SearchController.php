<?php


namespace BeFlo\T3Elasticsearch\Controller;


use BeFlo\T3Elasticsearch\Hook\Interfaces\SearchControllerConfigurationHook;
use BeFlo\T3Elasticsearch\Service\SearchService;
use BeFlo\T3Elasticsearch\Utility\HookTrait;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;

class SearchController extends ActionController
{
    use HookTrait;

    /**
     * Initializes the controller before invoking an action method.
     *
     * Override this method to solve tasks which all actions have in
     * common.
     */
    protected function initializeAction()
    {
        $this->initHooks(self::class);
    }

    public function indexAction()
    {

    }

    /**
     * @throws StopActionException
     */
    public function resultAction()
    {
        if(!$this->request->hasArgument('searchTerm')) {
            $this->redirect('index');
        }
        $data = $this->configurationManager->getContentObject()->data;
        if(!empty($data['pi_flexform'])) {
            $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
            $configuration = $flexFormService->convertFlexFormContentToArray($data['pi_flexform']);
            $searchService = GeneralUtility::makeInstance(SearchService::class);
            $params = [&$configuration];
            $this->executeHook(SearchControllerConfigurationHook::class, $params);
            $searchService->search($configuration);
        } else {
            $this->redirect('index');
        }
    }
}