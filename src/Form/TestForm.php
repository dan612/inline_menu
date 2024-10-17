<?php

namespace Drupal\inline_menu\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TestForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
      return 'test_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['boxes'] = array(
      '#type' => 'checkboxes',
      '#theme' => 'template_name',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
      '#options' => [
        'option1' => t('Option 1'),
        'option2' => t('Option 2'),
        'option3' => t('Option 3')
      ],
      '#default_value' => [],
    );

    return $form;

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}
