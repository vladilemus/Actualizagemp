<?php 
require('Table.php');
class Reporte {
	private $titulos;
	private $datos;
	private $tabla;
	private $paramTabla;
	function __CONSTRUCT($valor){
		$this->tabla= new Table();
		$this->paramTabla=$valor;
	}
	function setTitulos($valor){
		$this->titulos=$valor;
	}
	function setDatos($valor){
		$this->datos=$valor;
	}
	function SetColAttributesR ($col, $valorattrcol){
		$this->tabla->SetColAttributes ( $col, $valorattrcol );
	}
	function SetCellAttributesR ( $row, $col, $valorattrcol ){
		$this->tabla->SetCellAttributes ( $row, $col, $valorattrcol );
	}
	
	function SetRowAttributesR ($row, $valorattrcol){
		$this->tabla->SetRowAttributes ( $row, $valorattrcol );
	}
	
	function SetDefaultCellAttributes ( $array ){
		$this->tabla->SetDefaultCellAttributes ( $array );
	}
	function SetTableAttributeR ( $key, $value )
	{
		$this->tabla->SetTableAttribute ( $key, $value );
	}
	function SetCellColSpanR ( $row, $col, $colspan ){
		$this->tabla->SetCellColSpan ( $row, $col, $colspan );
	}
	function displayDatos($paramTitulos,$paramDatos,$boolTitulos='yes',$line0=array(), $collsp=array(), $cfg_collsp=array()){
		
		$this->tabla->addrow(sizeof($this->datos)+($boolTitulos=='yes'?1:0)+(sizeof($line0)>0?1:0));
		$this->tabla->addcol(sizeof($this->titulos));
		$this->tabla->setTableAttributes($this->paramTabla);		
		$this->tabla->SetDefaultCellAttributes($paramDatos);
		$tmpposrow=2;
		$tmpposrow2=2;
		if ($boolTitulos=='yes'){
			if(sizeof($line0)>0){
				$this->tabla->setRowContent(1,1,$line0);
				$this->tabla->SetRowAttributes(1,$cfg_collsp);
				$this->tabla->SetRowAttributes(2,$paramTitulos);
				$this->tabla->setRowContent(2,1,$this->titulos);
				$tmpposrow=3;
			}else{
				$this->tabla->SetRowAttributes(1,$paramTitulos);
				$this->tabla->setRowContent(1,1,$this->titulos);
			}
		}else	{
			$tmpposrow=1;
		}
		if(isset($this->datos )){
		foreach ($this->datos as $cont =>$item)
			$this->tabla->setRowContent($cont+$tmpposrow,1,$item);
		}
		if(sizeof($collsp)>0)
			foreach ($collsp as $item_collsp)
				$this->tabla->SetCellColSpan ( $item_collsp[0], $item_collsp[1], $item_collsp[2] )	;
				 
			
		//$this->tabla->SetCellColSpan ( 3, 2, 4 )	;
		$this->tabla->display();
	}
}
?>
