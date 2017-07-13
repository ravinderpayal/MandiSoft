<?php
/**
 * PrintLang
 * Alias for `echo $this->lang->line('add_account');`
 * Var $l Label
 * Var $context Context/Object Mapper
 */
function PrintLangLabel($l,$context){
    echo ucwords($context->lang->line($l));
}