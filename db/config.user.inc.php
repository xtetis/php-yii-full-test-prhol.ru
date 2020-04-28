<?php

for ($i = 1;isset($hosts[$i - 1]); $i++)
{
    $cfg['Servers'][$i]['auth_type'] = 'config';
    $cfg['Servers'][$i]['user']      = 'root';
    $cfg['Servers'][$i]['password']  = 'rootpassword';
    $cfg['Servers'][$i]['CheckConfigurationPermissions'] = false;

}
