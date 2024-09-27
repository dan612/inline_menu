<?php

namespace Drupal\inline_menu\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'inline_menu' formatter.
 *
 * @FieldFormatter(
 *   id = "inline_menu_formatter",
 *   label = @Translation("Inline Menu Formatter"),
 *   field_types = {
 *     "inline_menu"
 *   }
 * )
 */
class InlineMenuFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the random string.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $links = [];
    foreach ($items as $item) {
      $links[] = [
        'title' => $item->title,
        'url' => $item->url,
        'nest_level' => $item->nest_level,
      ];
    }
    $render = [
      '#theme' => 'inline_menu',
      '#menu_links' => $links,
    ];
    $element = [];
    $element[] = $render;

    return $element;
  }

}
