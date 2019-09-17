<?php

/**
 * Computes the GIR score based on the given answers.
 * 
 * Sample usage:
 * <code>
 *   $gir = new TestGir($form_state['values']['questions']);
 *   $score = $gir->computeScore();
 * </code>
 */
class TestGir {

  private $answers = array();
  private $sections = array(
    'coherence' => 0,
    'orientation' => 0,
    'toilette' => 'B',
    'habillage' => 'B',
    'alimentation' => 'B',
    'elimination' => 'B',
    'transfert' => 0,
    'deplacements' => 'B',
  );

  private $groups = array(
    'A' => array(
      'C' => array(2000, 1200, 40  , 40  , 60  , 100 , 800 , 200),
      'B' => array(0   , 0   , 16  , 16  , 20  , 16  , 120 , 32),
      'levels' => array(3 => 3390, 2 => 4140, 1 => 4380),
    ),
    'B' => array(
      'C' => array(1500, 1200, 40  , 40  , 60  , 100 , 800 , -80),
      'B' => array(320 , 120 , 16  , 16  , 0   , 16  , 120 , -40),
      'levels' => array(4 => 2016),
    ),
    'C' => array(
      'C' => array(0   , 0   , 40  , 40  , 60  , 160 , 1000, 400),
      'B' => array(0   , 0   , 16  , 16  , 20  , 20  , 200 , 40),
      'levels' => array(6 => 1432, 5 => 1700),
    ),
    'D' => array(
      'C' => array(0   , 0   , 0   , 0   , 2000, 400 , 2000, 200),
      'B' => array(0   , 0   , 0   , 0   , 200 , 200 , 200 , 0),
      'levels' => array(7 => 2400),
    ),
    'E' => array(
      'C' => array(400 , 400 , 400 , 400 , 400 , 800 , 800 , 200),
      'B' => array(0   , 0   , 100 , 100 , 100 , 100 , 100 , 0),
      'levels' => array(8 => 1200),
    ),
    'F' => array(
      'C' => array(200 , 200 , 500 , 500 , 500 , 500 , 500 , 200),
      'B' => array(100 , 100 , 100 , 100 , 100 , 100 , 100 , 0  ),
      'levels' => array(9 => 800),
    ),
    'G' => array(
      'C' => array(150 , 150 , 300 , 300 , 500 , 500 , 400 , 200),
      'B' => array(0, 0, 200 , 200 , 200 , 200 , 200 , 100),
      'levels' => array(10 => 650),
    ),
    'H' => array(
      'C' => array(0   , 0   , 3000, 3000, 3000, 3000, 1000, 1000),
      'B' => array(0   , 0, 2000, 2000, 2000, 2000, 2000, 1000),
      'levels' => array(13 => 0, 12 => 2000, 11 => 4000),
    ),
  );

  public function __construct($answers) {
    $this->answers = $answers;
  }

  public function normalizeScore() {
    // Compute the answers per section
    foreach ($this->sections as $section => &$value) {
      $section_answers = $this->answers[$section];
      switch ($section) {
        case 'toilette':
        case 'alimentation':
        case 'elimination':
          if ($section_answers[0][0] == 'A' && $section_answers[0][1] == 'A') {
            $value = 'A';
          }
          else {
            if ($section_answers[0][0] == 'C' && $section_answers[0][1] == 'C') {
              $value = 'C';
            }
          }
          break;
        case 'habillage':
          if ($section_answers[0][0] == 'A' && $section_answers[0][1] == 'A' && $section_answers[0][2] == 'A') {
            $value = 'A';
          }
          if ($section_answers[0][0] == 'C' && $section_answers[0][1] == 'C' && $section_answers[0][2] == 'C') {
            $value = 'C';
          }
          break;
        case 'deplacements':
          if ($section_answers[0][0] == 'A' && $section_answers[1][0] == 'A' && $section_answers[2][0] == 'A') {
            $value = 'A';
          }
          if ($section_answers[0][0] == 'C' && $section_answers[1][0] == 'C' && $section_answers[2][0] == 'C') {
            $value = 'C';
          }
          break;
        default:
          $value = $section_answers[0][0];
      }
    }
    return $this->sections;
  }

  /**
   * Compute GIR score based on given answers
   * @return integer
   *  GIR score
   */
  function computeScore() {
    $this->normalizeScore();
    $rank = 0;
    foreach ($this->groups as $key => $group) {
      $this->computeGroupScore($rank, $this->sections, $group['C'], $group['B'], $group['levels']);
    }
    return substr('01222222334456', $rank, 1);
  }

  function computeGroupScore(&$rank, $sections, $scoresC, $scoresB, $rankings) {
    $gir = 0;
    if ($rank == 0) {
      $keys = array_keys($sections);
      for ($i = 0; $i <= 7; $i++) {
        $key = $keys[$i];
        if ($sections[$key] == 'C') {
          $scores = $scoresC;
          $gir += $scores[$i];
        }
        else if ($sections[$key] == 'B') {
          $scores = $scoresB;
          $gir += $scores[$i];
        }
      }
      foreach ($rankings as $idx => $r) {
        if ($gir >= $r) {
          $rank = $idx;
        }
      }
    }
  }

  /**
   * Score interpretation as text.
   * 
   * @param int $score
   * 
   * @return mixed|string
   * 
   * Returns a descriptive interpretation of the numeric score. The currently defined values are from 1 - 6:
   * <ul>
   *   <li><strong>1</strong> - Personne confinée au lit ou au fauteuil, dont les fonctions mentales sont gravement altérées et qui nécessite une présence indispensable et continue d'intervenants. Ou personne en fin de vie</li>
   *   <li><strong>2</strong> - Personne confinée au lit ou au fauteuil, dont les fonctions mentales ne sont pas totalement altérées et dont l'état exige une prise en charge pour la plupart des activités de la vie courante. Ou personne dont les fonctions mentales sont altérées, mais qui est capable de se déplacer et qui nécessite une surveillance permanente</li>
   *   <li><strong>3</strong> - Personne ayant conservé son autonomie mentale, partiellement son autonomie locomotrice, mais qui a besoin quotidiennement et plusieurs fois par jour d'une aide pour les soins corporels</li>
   *   <li><strong>4</strong> - Personne n'assumant pas seule ses transferts mais qui, une fois levée, peut se déplacer à l'intérieur de son logement, et qui a besoin d'aides pour la toilette et l'habillage. Ou personne n'ayant pas de problèmes locomoteurs mais qui doit être aidée pour les soins corporels et les repas</li>
   *   <li><strong>5</strong> - Personne ayant seulement besoin d'une aide ponctuelle pour la toilette, la préparation des repas et le ménage</li>
   *   <li><strong>6</strong> - Personne encore autonome pour les actes essentiels de la vie courante</li>
   * </ul>
   */
  function getTestInterpretation($score) {
    $scores = array();
    if ($voc = taxonomy_vocabulary_machine_name_load('gir_score')) {
      $q = new EntityFieldQuery();
      $q->entityCondition('entity_type', 'taxonomy_term');
      $q->propertyCondition('vid', $voc->vid);
      $q->propertyOrderBy('weight');
      $result = $q->execute();
      if (!empty($result['taxonomy_term'])) {
        $tids = array_keys($result['taxonomy_term']);
        $terms = taxonomy_term_load_multiple($tids);
        foreach ($terms as $term) {
          $scores[$term->name] = $term->description;
        }
      }
    }
    return isset($scores[$score]) ? $scores[$score] : '';
  }
}
