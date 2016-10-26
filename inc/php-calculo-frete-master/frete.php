<?php

class Frete {

	//$frete = new Frete('09854100', '01310100', '0.5', '4', '12', '16', '1.00');
	
	const URL = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
	const SERVICE = "41106";
	private $xml;

	public function __construct(
		$CEPorigem,
		$CEPdestino,
		$peso,
		$comprimento,
		$altura,
		$largura,
		$valor
	){

		if ($comprimento < 16) $comprimento = 16;

		$this->xml = simplexml_load_file(Frete::URL."nCdEmpresa=&sDsSenha=&sCepOrigem=".$CEPorigem."&sCepDestino=".$CEPdestino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor."&sCdAvisoRecebimento=n&nCdServico=".Frete::SERVICE."&nVlDiametro=0&StrRetorno=xml");

		if(!$this->xml->cServico){
	        throw new Exception("Error Processing Request", 400);	        
	    }

	}

	public function getValor(){

		return (float)str_replace(',', '.', $this->xml->cServico->Valor);

	}

	public function getPrazoEntrega(){

		return (int)$this->xml->cServico->PrazoEntrega;

	}

	public function getValorSemAdicionais(){

		return (float)str_replace(',', '.', $this->xml->cServico->ValorSemAdicionais);

	}

	public function getValorMaoPropria(){

		return (float)str_replace(',', '.', $this->xml->cServico->ValorMaoPropria);

	}

	public function getValorAvisoRecebimento(){

		return (float)str_replace(',', '.', $this->xml->cServico->ValorAvisoRecebimento);

	}

	public function getValorValorDeclarado(){

		return (float)str_replace(',', '.', $this->xml->cServico->ValorValorDeclarado);

	}

}