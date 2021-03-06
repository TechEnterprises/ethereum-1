<?php

namespace Drupal\ethereum\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ethereum\EthereumServerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Returns responses for Ethereum UI routes.
 */
class EthereumUIController extends ControllerBase {

  /**
   * Calls a method on an ethereum_server entity and reloads the listing page.
   *
   * @param \Drupal\ethereum\EthereumServerInterface $ethereum_server
   *   The server being acted upon.
   * @param string $op
   *   The operation to perform, e.g., 'enable' or 'disable'.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse|\Symfony\Component\HttpFoundation\RedirectResponse
   *   Either returns a rebuilt listing page as an AJAX response, or redirects
   *   back to the listing page.
   */
  public function ajaxOperation(EthereumServerInterface $ethereum_server, $op, Request $request) {
    // Perform the operation.
    $ethereum_server->$op()->save();

    // If the request is via AJAX, return the rendered list as JSON.
    if ($request->request->get('js')) {
      $list = $this->entityTypeManager()->getListBuilder('ethereum_server')->render();
      $response = new AjaxResponse();
      $response->addCommand(new ReplaceCommand('#ethereum-server-list', $list));
      return $response;
    }

    // Otherwise, redirect back to the page.
    return $this->redirect('entity.ethereum_server.collection');
  }

}
