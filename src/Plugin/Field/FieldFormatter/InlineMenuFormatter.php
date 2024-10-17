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
      if (str_starts_with($item->url, '/node')) {
        $exploded_url = explode('/', $item->url);
        $nid = $exploded_url[2];
        $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $nid]);
        $url = $url->toString();
      }
      else {
        $url = $item->url;
      }

      $links[] = [
        'title' => $item->title,
        'url' => $url,
        'nest_level' => $item->nest_level,
        'has_children' => FALSE,
      ];
    }
    $nested = [];
    foreach ($links as $index => $link_data) {
      $nest_level = $link_data['nest_level'] ?? FALSE;
      if (!$nest_level) {
        $nested[$index] = $link_data;
        continue;
      }
      if ($nest_level == "1") {
        for ($i = 1; $i <= 4; $i++) {
          $parent = $index - $i;
          if (isset($links[$parent]) && $links[$parent]['nest_level'] == "0") {
            $nested[$parent]['has_children'] = TRUE;
            $nested[$parent]['children'][] = $link_data;
            break;
          }
        }
      }

      if ($nest_level == "2") {
        for ($i = 1; $i <= 10; $i++) {
          $root = $index - $i;
          if (isset($links[$root]) && $links[$root]['nest_level'] == "0") {
            // skip strays.
            if (!isset($nested[$root]['children']) || is_null($nested[$root]['children'])) {
              continue;
            }
            $last_child = end($nested[$root]['children']);
            $key = key($nested[$root]['children']);
            $nested[$root]['children'][$key]['has_children'] = TRUE;
            $nested[$root]['children'][$key]['children'][] = $link_data;
            break;
          }
        }
      }
    }
    // Move children underneath parents.
    $render = [
      '#theme' => 'inline_menu',
      '#menu_links' => $nested,
    ];
    $element = [];
    $element[] = $render;

    return $element;
  }

}
