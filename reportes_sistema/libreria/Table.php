<?php
/*
 *      PROY/MOD:       IICA
 *      ARCHIVO:        Table.class
 *      AUTOR:          Gustavo A. Cortez Aguilar, Roberto Lopez, Daniel Barajas
 *      OBJETIVO:       Genera el codigo de tablas en HTML a partir de una serie de arreglos
 *                      
 */

/*
*	Table Class
*	Este es el orden de precedencia de los estilos.
*		1. Default
*		2. Row
*		3. Column
*		4. Individually Assigned
*/

class Table
{
	var $table;
	var $default_settings;
	var $row_count;
	var $cols_count;
	var $fstyles;
	
	/*CONSTRUCTOR*/
	function Table ()
	{
		$this->table				= array();
		$this->default_settings		= array();
		$this->row_count			= 0;
		$this->cols_count			= 0;
		$this->default_settings		= array();
		$this->fstyles				= array();
	}

/****************************************************************/
/*								*/
/*	METODOS PARA ATRIBUTOS DE LA ETIQUETA TABLE		*/
/*								*/
/****************************************************************/

	/*ESTABLECE VARIOS ATRIBUTOS + VALORES DEFAULT A LA 
	  ETIQUETA TABLE A TRAVES DE ARREGLO*/
	function SetDefaultTableAttribute ( $array )
	{
		foreach ( $array as $key => $value )
		{
			$this->default_settings["table"][$key] = $value;
		}
	}
	
	/*ESTABLECE VARIOS ATRIBUTOS + VALORES A LA ETIQUETA TABLE A 
	  TRAVES DE ARREGLO*/
	function SetTableAttributes ( $array )
	{
		foreach ( $array as $key => $value )
		{
		$this->table[0]["table_values"][$key] = $value;
		}
	}
	
	/*ESTABLECE UN ATRIBUTO + VALOR A LA ETIQUETA TABLE*/
	function SetTableAttribute ( $key, $value )
	{
		$this->table[0]["table_values"][$key] = $value;
	}


/****************************************************************/
/*								*/
/*		METODOS PARA TAMAÑO Y ESTRUCTURA DE LA TABLA	*/
/*								*/
/****************************************************************/

	/*AGREGAR N FILAS*/	
	function AddRow ($rows="1")
	{
		return $this->row_count += $rows;
	}

	/*AGREGAR N COLUMNAS*/
	function AddCol ($cols="1", $content="&nbsp;")
	{
		for ($i=1;$i<$this->row_count+1;$i++){
			for($j=1;$j<$cols+1;$j++){
				$this->table[$i][$j]["content"] = $content;
			}
		}
	}

	/*HACE COLSPAN DE N CELDAS*/
	function SetCellColSpan ( $row, $col, $colspan )
	{
		$this->table[$row][$col]["colspan"] = $colspan;
		for($i=0;$i<$colspan-1;$i++){
			$this->DelColumn($row);
		}
	}

	/*HACE ROWSPAN DE N CELDAS*/
	function SetCellRowSpan ( $row, $col, $rowspan )
	{
		$this->table[$row][$col]["rowspan"] = $rowspan;
		$csp = $this->ExistColSpan($row,$col);
		for($i=0;$i<$rowspan-1;$i++){
			$row++;
			$this->DelColumn($row);
			if($csp >0){
				for($j=0;$j<$csp;$j++){
					$this->DelColumn($row);
				}
			}
		}
	}

	/*OBTENER NUMERO DE FILAS*/
	function GetCurrentRow ()
	{
		return $this->row_count;
	}

	/*OBTENER NUMERO DE COLUMNAS*/
	function GetCurrentCol ($row)
	{
		$tmp = $this->table[$row];
		$cols_count = count ( $tmp );
		return $this->cols_count = $cols_count;
	}

	/*ELIMINA LA ULTIMA COLUMNA DE UNA FILA ESPECIFICA*/
	function DelColumn ($row)
	{
			$cuenta = $this->GetCurrentCol($row);
			unset ($this->table[$row][$cuenta]);			
	}

	/*DEVULEVE EL VALOR DE UN COLSPAN DE UNA CELDA*/
	function ExistColSpan($row,$col)
	{
		$exist = $this->table[$row][$col]["colspan"];
		if($exist=='')
			return $exist=0;
		else
			return $exist-1;			
	}

/****************************************************************/
/*								*/
/*		METODOS PARA ESTILO DE LAS CELDAS		*/
/*								*/
/****************************************************************/

	/*ESTABLECE COLOR DEFAULT TODAS LAS CELDAS*/
	function SetDefaultBGColor ( $bgcolor )
	{
		$this->default_settings['td']['bgcolor'] = $bgcolor;
	}

	/*ESTABLECE BGCOLOR A CELDA ESPECIFICA*/
	function SetCellBGColor ( $row, $col, $bgcolor )
	{
		$this->table[$row][$col]["bgcolor"] = $bgcolor;
	}

	/*ESTABLECE UN CSS DEFAULT TODAS LAS CELDAS*/
	function SetDefaultStyle ( $style )
	{
	$this->default_settings['td']['style'] = $style;
	}

	/*ESTABLECE UN CSS A UNA CELDA ESPECIFICA*/
	function SetCellStyle ( $row, $col, $style )
	{
		$this->table[$row][$col]["style"] = $style;
	}

	/*ESTABLECE UN ATRIBUTO + VALOR DEFAULT A TODAS LAS CELDAS*/	
	function SetDefaultCellAttribute ( $attribute, $value )
	{
		$this->default_settings['td'][$attribute] = $value;
	}

	/*ESTABLECE UN ATRIBUTO + VALOR A UNA CELDA ESPECIFICA*/	
	function SetCellAttribute ( $row, $col, $attribute, $value )
	{
		$this->table[$row][$col][$attribute] = $value;
	}

	/*ESTABLECE VARIOS ATRIBUTOS + VALORES DEFAULT A TODAS LAS CELDAS A TRAVES DE ARREGLO*/
	function SetDefaultCellAttributes ( $array )
	{
		foreach ( $array as $key => $value )
		{
			$this->default_settings['td'][$key] = $value;
		}
	}

	/*ESTABLECE VARIOS ATRIBUTOS + VALORES A UNA CELDA ESPEFICIFICA A TRAVES DE ARREGLO*/
	function SetCellAttributes ( $row, $col, $array )
	{
		if (is_array($array))
		{
			foreach ( $array as $attribute => $value )
			{
				$this->table[$row][$col][$attribute] = $value;
			}
		}
	}

	/*ESTABLECE VARIOS ATRIBUTOS + VALORES A UNA O VARIAS
	  FILAS ESPECIFICA TRAVES DE DOS ARREGLO*/	
	function SetRowAttributes ( $row, $attributes )
	{
		if ( is_array( $row ) )
		{
			foreach ( $row as $num )
			{
				foreach( $attributes as $key => $value )
				{
					$this->fstyles["row"][$num][$key] = $value;
				}
			}
		} else {
			foreach( $attributes as $key => $value )
			{
				$this->fstyles["row"][$row][$key] = $value;
			}
		}
	}
	
	/*ESTABLECE VARIOS ATRIBUTOS + VALORES A UNA O VARIAS
	  COLUMNAS ESPECIFICA TRAVES DE DOS ARREGLO*/	
	function SetColAttributes ( $col, $attributes )
	{
		if ( is_array( $col ) )
		{
			foreach ( $col as $num )
			{
				foreach( $attributes as $key => $value )
				{
					$this->fstyles["col"][$num][$key] = $value;
				}
			}
		} else {
			foreach( $attributes as $key => $value )
			{
				$this->fstyles["col"][$col][$key] = $value;
			}
		}
	}

	/*ESTABLECE DOS COLORES ALTERNADOS ENTRE FILAS*/
	function Set2RowColors( $odd_colors, $even_colors, $start=1, $end=false)
	{
		if( $end == false )
		{
			$end = $this->GetCurrentRow();
		}
		for( $row = $start; $row <= $end; $row++ )
		{
			if ( ( $row % 2 ) != 0 )
			{
				$this->fstyles["row"][$row]["bgcolor"] = $odd_colors;
			} else {
				$this->fstyles["row"][$row]["bgcolor"] = $even_colors;
			}
		}
	}

/****************************************************************/
/*								*/
/*	METODOS PARA AGREGAR CONTENIDO A LAS CELDAS		*/
/*								*/
/****************************************************************/

	/*AGREGAR CONTENIDO POR FILA Y COLUMNA*/	
	function SetCellContent ( $row, $col, $content )
	{
                $dataType =  gettype($content);
                if ($dataType == 'object')
			$this->table[$row][$col]["content"] = $content->body;
                else
			$this->table[$row][$col]["content"] = $content;
                        
	}
	/*AGREGAR CONTENIDO POR FILA A TRAVES DE ARREGLO*/
	function SetRowContent ( $row, $col, $content)
	{
		$x=$col;
		foreach ($content as $column => $contenido)
		{
			$dataType = gettype($contenido);
			if($dataType == 'object')
				$this->table[$row][$x]["content"] = $contenido->body;
			else
				$this->table[$row][$x]["content"] = $contenido;
			$x++;
		}
		
	}
	/*AGREGAR CONTENIDO POR COLUMNA A TRAVES DE ARREGLO*/
	function SetColContent ( $row, $col, $content )
	{
		$y=$row;
      /* Modificado por Roberto Lspez el dia 15 de Febrero porque si nohay columnas marca un warning */
        if(count($content)>0){
		foreach ($content as $column => $contenido)
		{
			$dataType = gettype($contenido);
			if($dataType == 'object')
				$this->table[$y][$col]["content"] = $contenido->body;
			else
				$this->table[$y][$col]["content"] = $contenido;
			$y++;
		}
          }
	}

/****************************************************************/
/*								*/
/*	METODOS DE USO INTERNO Y DE DESPLIEGE DE LA TABLA	*/
/*								*/
/****************************************************************/

	/*CONVIENRTE EL ARREGLO EN UNA CADENA CON FORMATO DE HTML DE LA TABLA*/
	function CompileTable()
	{
		$content = "\n<table";
		
		if (isset( $this->default_settings["table"] ) )
		{
			$t_array = $this->default_settings["table"];
				foreach ($t_array as $attribute => $value )
				{
					$this->table[0]["table_values"][$attribute] = $value;
				}
		}
		
		if (isset( $this->table[0]["table_values"] ))
		{
			$t_array = $this->table[0]["table_values"];
				foreach ( $t_array as $attribute => $value )
			{
				$content .= ' '.$attribute.'="'.$value.'"';
			}
		}
		
		$content .= ">\n";
		
		for ( $row = 1; $row <= $this->row_count; $row++ )
		{
			$content .= "\t<tr>\n";
			$row_array = $this->table[$row];
			
			$count = count( $row_array );
			for ( $col = 1; $col <= $count; $col++ )
			{
				$colvalue = array();
				$colvalue = $row_array[$col];
				$content .= "\t\t<td";
				$fcolstyle = "";
				
				$td_array = $this->default_settings["td"];
				
				if (isset($this->fstyles["row"][$row]))
				{
					$frowstyle = $this->fstyles["row"][$row];
				} else {
					$frowstyle = "";
				}
				
				if ( is_array( $frowstyle ) )
				{
					foreach ( $frowstyle as $attribute => $value )
					{
						$td_array[$attribute] = $value;
					}
				}
				if (isset($this->fstyles["col"][$col]) && !empty( $this->fstyles["col"][$col]))
				{
					$fcolstyle = $this->fstyles["col"][$col];
					if (is_array($fcolstyle))
					{
						foreach ($fcolstyle as $attribute => $value)
						{
							$td_array[$attribute] = $value;
							
						}
					}
				}
				
				if ( is_array( $td_array ) )
				{
					foreach ( $td_array as $attribute => $value )
					{
						if (empty($colvalue[$attribute]) || !isset($colvalue[$attribute]))
						{
							$colvalue[$attribute] = $value;
						}
					}
				}
				foreach ( $colvalue as $attribute => $value)
				{
					if ($attribute == "content")
					{
						$t_string = $value;
					}
					elseif ($attribute == "atributo"){
                                                $content .= " $value";
                                        }
					else {
						$content .= " $attribute=\"$value\"";
					}
				}
				$content .= ">\n";
				$content .= "\t\t\t".$t_string."\n";
				$content .= "\t\t</td>\n";
			}
			$content .= "\t</tr>\n";
		}
		$content .= "</table>\n";
		return $content;
	}
	
	/*REGRESA $THIS->BODY*/
	function getBody()
	{
		$body=$this->CompileTable();
		$this->body = $body;
	}
	
	/*IMPRIME LA TABLA*/		
	function display()	
	{
		echo $this->CompileTable();
	}
	/*IMPRIME EL ARREGLO USADO PARA DEBUG*/
	function printTableArray()
	{
		echo "<pre>";
		print_r( $this );
		echo "</pre>";
	}

	/*REGRESA $THIS->BODY*/
	function returnGetBody()
	{
		$body=$this->CompileTable();
		return $body;
	}

}

?>
