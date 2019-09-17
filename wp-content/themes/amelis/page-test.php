<?php
/*
  *  Uses a custom header and footer (to be shared by other forms)
  *
*/
get_header("forms");

?>



<div class="form-page test-gir step-1">

    <div id="testGir">
        <input id="current_step" type="hidden" name="current_step" value="1">

        <section class="section form-steps">
            <div class="text-center">
                <div class="steps-container">
                    <a href="#" data-question="1" class="step step--active"></a>
                    <a href="#" data-question="2" class="step"></a>
                    <a href="#" data-question="3" class="step"></a>
                    <a href="#" data-question="4" class="step"></a>
                    <a href="#" data-question="5" class="step"></a>
                    <a href="#" data-question="6" class="step"></a>
                    <a href="#" data-question="7" class="step"></a>
                    <a href="#" data-question="8" class="step"></a>
                    <a href="#" data-question="9" class="step"></a>
                    <a href="#" data-question="10" class="step"></a>
                    <a href="#" data-question="11" class="step"></a>
                    <a href="#" data-question="12" class="step"></a>
                    <a href="#" data-question="13" class="step"></a>
                    <a href="#" data-question="14" class="step"></a>
                    <a href="#" data-question="15" class="step"></a>
                    <a href="#" data-question="16" class="step"></a>
                    <a href="#" data-question="17" class="step"></a>
                </div>
            </div>
        </section>
        <section class="section section-etape">
            <div class="container">
                <div id="etape-1" class="etape-step-holder">

                    <div class="etape-1 question-1 active">
                        <div class="question-and-description">

                            <div style="max-width: 600px; margin: 0 auto;">
                                <div class="text-center">
                                    <h1>Test GIR</h1><br>
                                    <p>
                                        <strong>Remplissez le test avec soin.</strong><br>
                                        Le résultat ne vous est communiqué qu’à titre d’information*.<br>
                                        <small><em>*Ce test ne remplace pas une véritable évaluation faite avec un médecin gérontologue.</em></small>
                                    </p>
                                </div><br>

                                <p><strong>Pour la personne âgée concernée, donnez une évaluation : A, B ou C.</strong></p>
                                <ul class="list-unstyled">
                                    <li>A : Fait spontanément seul, en totalité</li>
                                    <li>B : Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</li>
                                    <li>C : Ne fait pas, ne peut pas, refuse de faire</li>
                                </ul>
                                <input type="radio" style="display: none" name="test_info" checked="checked" value="1">
                                <div class="h-space-50 visible-xs"></div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q1 -->

                    <div class="etape-1 question-2" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Cohérence</h3>
                            <p class="text-center">Converser et se comporter de façon sensée par rapport aux normes admises</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[coherence][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[coherence][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, <br class="hidden-xs"> incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[coherence][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q1 -->
                    <div class="etape-1 question-3" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Orientation</h3>
                            <p class="text-center">Se repérer dans le temps (jour et nuit, matin et soir), dans les lieux habituels...</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[orientation][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[orientation][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[orientation][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q2 -->
                    <div class="etape-1 question-4" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Toilette du haut</h3>
                            <p class="text-center">(visage, tronc, membres supérieurs, rasage, coiffage)
                                <br>
                                <strong>Faire seul, en entier, habituellement et correctement :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q3 -->
                    <div class="etape-1 question-5" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Toilette du bas</h3>
                            <p class="text-center">(régions intimes, membres inférieurs, pieds)
                                <br>
                                <strong>Faire seul, en entier, habituellement et correctement :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][1]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][1]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[toilette][0][1]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q4 -->
                    <div class="etape-1 question-6" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Habillage du haut</h3>
                            <p class="text-center">(bras, tête)
                                <br>
                                <strong>S'habiller seul, totalement et correctement :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q5 -->
                    <div class="etape-1 question-7" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Habillage milieu</h3>
                            <p class="text-center">(boutons, ceinture, bretelles...)
                                <br>
                                <strong>S'habiller seul, totalement et correctement :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][1]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][1]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][1]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q6 -->
                    <div class="etape-1 question-8" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Habillage du bas</h3>
                            <p class="text-center">(pantalon, chaussettes, bas, chaussures)
                                <br>
                                <strong>S'habiller seul, totalement et correctement :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][2]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][2]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[habillage][0][2]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q7 -->
                    <div class="etape-1 question-9" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Alimentation</h3>
                                <p class="text-center">(couper la viande, ouvrir un pot, se verser à boire, peler un fruit..)
                                    <br>
                                    <strong>S'alimenter seul et correctement. Capacité à "se servir" :</strong>
                                </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q8 -->
                    <div class="etape-1 question-10" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Alimentation</h3>
                            <p class="text-center">manger seul
                                <br>
                                <strong>S'alimenter seul et correctement. Capacité à "se servir" :</strong>
                            </p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][1]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][1]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[alimentation][0][1]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q9 -->
                    <div class="etape-1 question-11" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Élimination urinaire</h3>
                            <p class="text-center">Assure seul et correctement l'hygiène de l'élimination :</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q10 -->
                    <div class="etape-1 question-12" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Elimination anale</h3>
                            <p class="text-center">Assure seul et correctement l'hygiène de l'élimination :</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][1]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][1]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[elimination][0][1]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q11 -->
                    <div class="etape-1 question-13" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Transfert</h3>
                            <p class="text-center">Se lève (du lit, du canapé, du sol), se couche et s'assoit seul</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[transfert][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[transfert][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[transfert][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q12 -->
                    <div class="etape-1 question-14" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Déplacements intérieurs</h3>
                            <p class="text-center">Se déplace seul (éventuellement avec canne, déambulatoire ou fauteuil roulant)</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][0][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][0][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][0][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q13 -->
                    <div class="etape-1 question-15" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Déplacements extérieurs</h3>
                            <p class="text-center">Dépasse seul le seuil de sa porte (ne change pas le GIR)</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][1][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][1][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][1][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q14 -->
                    <div class="etape-1 question-16" style="display: none">
                        <div class="question-and-description">
                            <h3 class="text-center">Communication à distance</h3>
                            <p class="text-center">Utilise les moyens de communication à distance - cris, téléphone, alarme.. (ne change pas le GIR)</p>
                        </div>
                        <div class="form-container rejoignez-nous gir">
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][2][0]" value="A" class="btn-radio">
                                <div class="radio-tile">
                                    <label>A</label>
                                    <span>Fait spontanément seul, <br class="hidden-xs"> en totalité</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][2][0]" value="B" class="btn-radio">
                                <div class="radio-tile">
                                    <label >B</label>
                                    <span>Fait partiellement, irrégulièrement, incorrectement, ou sur incitation</span>
                                </div>
                            </div>
                            <div class="input-container">
                                <input type="radio" name="questions[deplacements][2][0]" value="C" class="btn-radio">
                                <div class="radio-tile">
                                    <label>C</label>
                                    <span>Ne fait pas, ne peut pas, <br>refuse de faire</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .etape-1 .q15 -->

                </div> <!-- #etape-1 -->
                <div id="etape-3" class="etape-step-holder" style="display:none">
                    <div class="etape-2 text-inputs">

                    <?php wp_nonce_field( 'web_form_action', 'web_form_wpnonce' ) ?>
                    <input type="text" name="your_subject" class="d-none" value="">

                    <div class="text-input">
                            <?php show_name_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_telephone_field(false, 'Mon Téléphone', 'amelis_tph_field'); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input">
                            <?php show_email_field(); ?>
                            <span class="validation-message"></span>
                        </div>
                        <div class="text-input code-postal">
                            <label for="randomcp_field_name">
                                <span> Code postal de la personne aidée * </span>
                                <input id="showAgenceBool" type="hidden" value="false">
                                <input type="text" pattern="[0-9]*" inputmode="numeric" onkeydown="return FilterInput(event)" placeholder="Code postal de la personne aidée *" id="randomcp_field_name" required="required">
                                <input type="text" placeholder="" id="randomcp_field_name_text_with_location" style="display: none">
                                <!-- <p><strong style="display: none" class="agence-found"></strong></p> -->
                            </label>
                            <span class="validation-message"></span>
                        </div>

                        <?php show_newsletter_checkbox(); ?>

                        <label class="newsletter-sign" for="contacte-sign">
                            <input type="checkbox" id="contacte-sign" value="1"> Je souhaite être contacté(e) par Amelis au sujet de cette demande de document
                        </label>
                    </div> <!-- .etape-2 -->
                </div> <!-- #etape-2 -->
            </div> <!-- .container -->
        </section>
    </div>


    <footer class="form-footer fixed">
        <nav class="form-footer-nav">
            <a href="#" class="btn btn-nav back disabled"><?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-left.svg") ?> Retour</a>
            <a href="#" class="btn btn-nav forward btn-etape-1 btn-finish-gir active"><span>Suivant</span> <?php echo file_get_contents(get_bloginfo('template_url') . "/assets/images/arrow-right.svg") ?></a>
        </nav>
        <div id="gdprContainer" class="container" style="display: none">
            <div class="gdpr"><?php echo get_field("gdpr_message") ?></div>
        </div>
    </footer>
</div> <!-- started in header -->

<?php get_footer("forms"); ?>