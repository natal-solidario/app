<?php
class NatalSolidario_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get todas as regioes administrativas
     */
    function get_all_regiao_administrativa()
    {
        $this->db->order_by('nome', 'asc');
        return $this->db->get('regiao_administrativa')->result_array();
    }

    function get_all_uf()
    {
        $this->db->order_by('nome', 'asc');
        return $this->db->get('uf')->result_array();
    }

    function get_all_config()
    {

        $config = $this->db->get('config')->result_array();

        $retorno = array();
        foreach($config as $c)
        {
            $retorno[$c['chave']] = $c['valor'];
        }

        return $retorno;
    }

    function validar_cpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

        // Checa se os números são todos iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Checa se os números são todos iguais
        // if (preg_match('/(\d)\1{10}/', $cnpj)) return false;
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;	
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }
}