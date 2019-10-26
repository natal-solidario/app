<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth ACL
*
* Version: 1.0.0
*
* Author: Steve Goodwin
*		  steve@weblogics.co.uk
*         @steveg1987
*
* Location: http://github.com/steve-goodwin/ion_auth_acl
*
* Created:  18.09.2015
*
* Description:  Add's ACL (access control list) based on the existing Ion Auth library for codeigniter
*
* Requirements: PHP5 or above
*
*/

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['permissions']            = 'atributo';
$config['tables']['group_permissions']      = 'x_perfil_atributo';
$config['tables']['users_permissions']      = 'x_usuario_atributo';

/*
 | Permissions table column and Users / Groups permissions table column's you want to join WITH.
 |
 | Joins from permissions.perm_id
 */
$config['join']['permissions']  = 'perm_id';

/*
 | -------------------------------------------------------------------------
 | Authentication options.
 | -------------------------------------------------------------------------
 | Default admin permission = admin_access
 */
$config['admin_permission']                 = "acesso_admin";       // Default administrators permission, use key

/* End of file ion_auth_acl.php */
/* Location: ./application/config/ion_auth_acl.php */
