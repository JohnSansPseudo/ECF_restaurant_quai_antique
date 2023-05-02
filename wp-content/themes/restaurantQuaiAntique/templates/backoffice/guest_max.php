<?php
$sContent = '<div class="container">
                    <h4>Nombre de clients maximum</h4>
                        <form method="post" action="../../../../../wp-admin/options.php">';
ob_start();
settings_fields("guest_max_section");
do_settings_sections("QuaiAntiqueParam");
submit_button('Enregistrer');
$sContent .= ob_get_clean();

$sContent .= '</form></div>';
