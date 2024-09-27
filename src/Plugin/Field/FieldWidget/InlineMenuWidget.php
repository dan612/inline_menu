<?php

namespace Drupal\inline_menu\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field_example_text' widget.
 *
 * @FieldWidget(
 *   id = "inline_menu_widget",
 *   module = "inline_menu",
 *   label = @Translation("Inline Menu Widget"),
 *   field_types = {
 *     "inline_menu"
 *   }
 * )
 */
class InlineMenuWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /* $element += [ */
    /*   '#type' => 'fieldset', */
    /*   '#title' => 'Inline Menu Items', */
    /*   'links' => [], */
    /*   '#default_value' => isset($items[$delta]) ? $items[$delta]->getValue() : NULL */
    /* ]; */

    $title = isset($items[$delta]->title) ? $items[$delta]->title : '';
    $url = isset($items[$delta]->url) ? $items[$delta]->url : '';
    $nest_level = isset($items[$delta]->nest_level) ? $items[$delta]->nest_level : '';

    $element['links']['title'] = [
      '#type' => 'textfield',
      '#title' => t('Link Title'),
      '#default_value' => $title,
      '#size' => 255,
      '#maxlength' => 255,
    ];
    $element['links']['url'] = [
      '#type' => 'linkit',
      '#title' => t('Link URL'),
      '#default_value' => $url,
      '#autocomplete_route_name' => 'linkit.autocomplete',
      '#autocomplete_route_parameters' => [
        'linkit_profile_id' => 'default',
      ],
    ];
    $element['links']['nest_level'] = [
      '#type' => 'select',
      '#default_value' => $nest_level,
      '#title' => t('Nest Level'),
      '#options' => [
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
      ],
    ];

    return [
      'title' => $element['links']['title'],
      'url' => $element['links']['url'],
      'nest_level' => $element['links']['nest_level'],
    ];
  }

}
