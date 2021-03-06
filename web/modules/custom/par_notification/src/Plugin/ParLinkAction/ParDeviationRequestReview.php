<?php

namespace Drupal\par_notification\Plugin\ParLinkAction;

use Drupal\Core\Url;
use Drupal\message\MessageInterface;
use Drupal\par_notification\ParLinkActionBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Send the user to the deviation review page if it has not already been reviewed.
 *
 * @ParLinkAction(
 *   id = "deviation_review",
 *   title = @Translation("Review deviation request."),
 *   status = TRUE,
 *   weight = 1,
 *   notification = {
 *     "new_deviation_request",
 *     "new_deviation_response",
 *   }
 * )
 */
class ParDeviationRequestReview extends ParLinkActionBase {

  public function receive(MessageInterface $message) {
    if ($message->hasField('field_deviation_request') && !$message->get('field_deviation_request')->isEmpty()) {
      $par_data_deviation_request = current($message->get('field_deviation_request')->referencedEntities());

      $destination = Url::fromRoute('par_deviation_review_flows.respond', ['par_data_deviation_request' => $par_data_deviation_request->id()]);

      if ($par_data_deviation_request->isAwaitingApproval() && $destination->access($this->user)) {
        return new RedirectResponse($destination->toString());
      }
    }
  }
}
