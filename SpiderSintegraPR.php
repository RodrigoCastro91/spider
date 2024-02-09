<?php

class SpiderSintegraPR {
    private $url = 'http://www.sintegra.fazenda.pr.gov.br/sintegra/';

    public function buscarInformacoes($cnpj) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(array(
                'num_cnpj' => $cnpj,
                'num_ie' => '',
                'num_cpf' => '',
                'botao' => 'Consultar',
                'txtcaptcha' => '', 
            )),
            CURLOPT_COOKIEFILE => 'cookies.txt', 
            CURLOPT_COOKIEJAR => 'cookies.txt',
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        
        if (strpos($response, 'Captcha inválido') !== false) {
            return "Captcha digitado incorretamente";
        }

    
        if (strpos($response, 'Nenhum dado encontrado para este CNPJ') !== false) {
            return "CNPJ/IE não encontrado";
        }

    
        preg_match_all('/<td class="tabelaDetalhe"[^>]*>(.*?)<\/td>/s', $response, $matches);

        $result = array_map('strip_tags', $matches[1]);
        $result = array_map('utf8_encode', $result);

        return $result;
    }
}
