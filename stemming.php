<?php
	/**
	* 
	*/
	class Stemming
	{
		public function cekKamus($kata){
			// cari di database
			$sql = "SELECT * from kata_dasar where katadasar ='$kata' LIMIT 1";
			//echo $sql.'<br/>';
			$result = mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($result)==1){
				return true; // True jika ada
			}
			else{
				return false; // jika tidak ada FALSE
			}
		}
		 
		// Hapus Inflection Suffixes (-lah, -kah, -ku, -mu, atau -nya)
		private function Del_Inflection_Suffixes($kata){
			$kataAsal = $kata;
			if(eregi('([km]u|nya|[kl]ah|pun)$',$kata)){ // Cek Inflection Suffixes
				$__kata = eregi_replace('([km]u|nya|[kl]ah|pun)$','',$kata);
				if(eregi('([klt]ah|pun)$',$kata)){ // Jika berupa particles (-lah, -kah, -tah atau -pun)
					if(eregi('([km]u|nya)$',$__kata)){ // Hapus Possesive Pronouns (-ku, -mu, atau -nya)
						$__kata__ = eregi_replace('([km]u|nya)$','',$__kata);
						return $__kata__;
					}
				}
				return $__kata;
			}
			return $kataAsal;
		}
		 
		private function Cek_Rule_Precedence($kata){
			if(eregi('^(be)[[:alpha:]]+(lah|an)$',$kata)){ // be- dan -i
				return true;
			}
			if(eregi('^(di|([mpt]e))[[:alpha:]]+(i)$',$kata)){ // di- dan -an
				return true;
			}
			return false;
		}

		// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
		private function Cek_Prefix_Disallowed_Sufixes($kata){
			if(eregi('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
				return true;
			}
			if(eregi('^(di)[[:alpha:]]+(an)$',$kata)){ // di- dan -an
				return true;
			}
			if(eregi('^(ke)[[:alpha:]]+(i|kan)$',$kata)){ // ke- dan -i,-kan
				return true;
			}
			if(eregi('^(me)[[:alpha:]]+(an)$',$kata)){ // me- dan -an
				return true;
			}
			if(eregi('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
				return true;
			}
			return false;
		}
		 
		// Hapus Derivation Suffixes (-i, -an atau -kan)
		private function Del_Derivation_Suffixes($kata){
			$kataAsal = $kata;
			if(preg_match('/(kan)$/',$kata)){ // Cek Suffixes
				$__kata = preg_replace('/(kan)$/','',$kata);
				if($this->cekKamus($__kata)){ // Cek Kamus
					return $__kata;
				}
			}
			if(preg_match('/(an|i)$/',$kata)){ // cek -kan
				$__kata__ = preg_replace('/(an|i)$/','',$kata);
				if($this->cekKamus($__kata__)) { // Cek Kamus
					return $__kata__;
				}
			}
			if($this->Cek_Prefix_Disallowed_Sufixes($kata)){
				return $kataAsal;
			}
			return $kataAsal;
		}
		 
		// Hapus Derivation Prefix (di-, ke-, se-, te-, be-, me-, atau pe-)
		private function Del_Derivation_Prefix($kata){
			$kataAsal = $kata;
			/* ------ Tentukan Tipe Awalan ------------*/
			if(preg_match('/^(di|[ks]e)\S{1,}/',$kata)){ // Jika di-,ke-,se-
				$__kata = preg_replace('/^(di|[ks]e)/','',$kata);
				if($this->cekKamus($__kata)){
					return $__kata; // Jika ada balik
				}
				$__kata__ = $this->Del_Derivation_Suffixes($__kata);
				if($this->cekKamus($__kata__)){
					return $__kata__;
				}
			}
			if(preg_match('/^([^aiueo])e\\1[aiueo]\S{1,}/i',$kata)){ // aturan  37
				$__kata = preg_replace('/^([^aiueo])e/','',$kata);
				if($this->cekKamus($__kata)){
					return $__kata; // Jika ada balik
				}
				$__kata__ = $this->Del_Derivation_Suffixes($__kata);
				if($this->cekKamus($__kata__)){
					return $__kata__;
				}
			}

			if(preg_match('/^([tmbp]e)\S{1,}/',$kata)){ //Jika awalannya adalah te-, me-, be-, atau pe-
			/*------------ Awalan be-, ---------------------------------------------*/
				if(preg_match('/^(be)\S{1,}/',$kata)){ // Jika awalan be-,
					if(preg_match('/^(ber)[aiueo]\S{1,}/',$kata)){ // aturan 1.
						$__kata = preg_replace('/^(ber)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
						$__kata = preg_replace('/^(ber)/','r',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
			 
					if(preg_match('/^(ber)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ //aturan  2.
						$__kata = preg_replace('/^(ber)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
			 
					if(preg_match('/^(ber)[^aiueor][[:alpha:]]er[aiueo]\S{1,}/',$kata)){ //aturan  3.
						$__kata = preg_replace('/^(ber)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
			 
					if(preg_match('/^belajar\S{0,}/',$kata)){ //aturan  4.
						$__kata = preg_replace('/^(bel)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
					 
					if(preg_match('/^(be)[^aiueolr]er[^aiueo]\S{1,}/',$kata)){ //aturan  5.
						$__kata = preg_replace('/^(be)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
				}
		/*------------end be-, ---------------------------------------------*/

		/*------------ Awalan te-, ---------------------------------------------*/
				if(preg_match('/^(te)\S{1,}/',$kata)){ // Jika awalan te-, 
					if(preg_match('/^(terr)\S{1,}/',$kata)){
						return $kata;
					}
					if(preg_match('/^(ter)[aiueo]\S{1,}/',$kata)){ // aturan 6.
						$__kata = preg_replace('/^(ter)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
						$__kata = preg_replace('/^(ter)/','r',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
		 
					if(preg_match('/^(ter)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 7.
						$__kata = preg_replace('/^(ter)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
					if(preg_match('/^(ter)[^aiueor](?!er)\S{1,}/',$kata)){ // aturan 8.
						$__kata = preg_replace('/^(ter)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
					if(preg_match('/^(te)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 9.
						$__kata = preg_replace('/^(te)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
						 
					if(preg_match('/^(ter)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  35 belum bisa
						$__kata = preg_replace('/^(ter)/','',$kata);
						if($this->cekKamus($__kata)){
							return $__kata; // Jika ada balik
						}
						 
						$__kata__ = $this->Del_Derivation_Suffixes($__kata);
						if($this->cekKamus($__kata__)){
							return $__kata__;
						}
					}
				}
			/*------------end te-, ---------------------------------------------*/

			/*------------ Awalan me-, ---------------------------------------------*/
				if(preg_match('/^(me)\S{1,}/',$kata)){ // Jika awalan me-, 
					if(preg_match('/^(me)[lrwyv][aiueo]/',$kata)){ // aturan 10
					$__kata = preg_replace('/^(me)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
					 
				if(preg_match('/^(mem)[bfvp]\S{1,}/',$kata)){ // aturan 11.
					$__kata = preg_replace('/^(mem)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if(preg_match('/^(mempe)\S{1,}/',$kata)){ // aturan 12
					$__kata = preg_replace('/^(mem)/','pe',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if (preg_match('/^(mem)((r[aiueo])|[aiueo])\S{1,}/', $kata)){//aturan 13
				$__kata = preg_replace('/^(mem)/','m',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(mem)/','p',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
		 
				if(preg_match('/^(men)[cdjszt]\S{1,}/',$kata)){ // aturan 14.
					$__kata = preg_replace('/^(men)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				 
				if (preg_match('/^(men)[aiueo]\S{1,}/',$kata)){//aturan 15
					$__kata = preg_replace('/^(men)/','n',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(men)/','t',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(meng)[ghqk]\S{1,}/',$kata)){ // aturan 16.
					$__kata = preg_replace('/^(meng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
		 
				if(preg_match('/^(meng)[aiueo]\S{1,}/',$kata)){ // aturan 17
					$__kata = preg_replace('/^(meng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(meng)/','k',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ =$this-> Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(menge)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(meny)[aiueo]\S{1,}/',$kata)){ // aturan 18.
					$__kata = preg_replace('/^(meny)/','s',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(me)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
		/*------------end me-, ---------------------------------------------*/

		 
		/*------------ Awalan pe-, ---------------------------------------------*/
			if(preg_match('/^(pe)\S{1,}/',$kata)){ // Jika awalan pe-,
				if(preg_match('/^(pe)[wy]\S{1,}/',$kata)){ // aturan 20.
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				 
				if(preg_match('/^(per)[aiueo]\S{1,}/',$kata)){ // aturan 21
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(per)/','r',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				if(preg_match('/^(per)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ // aturan  23
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(per)[^aiueor][[:alpha:]](er)[aiueo]\S{1,}/',$kata)){ // aturan  24
					$__kata = preg_replace('/^(per)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(pem)[bfv]\S{1,}/',$kata)){ // aturan  25
					$__kata = preg_replace('/^(pem)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(pem)(r[aiueo]|[aiueo])\S{1,}/',$kata)){ // aturan  26
					$__kata = preg_replace('/^(pem)/','m',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pem)/','p',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				 
				if(preg_match('/^(pen)[cdjzt]\S{1,}/',$kata)){ // aturan  27
					$__kata = preg_replace('/^(pen)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
					 
				if(preg_match('/^(pen)[aiueo]\S{1,}/',$kata)){ // aturan  28
					$__kata = preg_replace('/^(pen)/','n',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pen)/','t',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
			 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(peng)[^aiueo]\S{1,}/',$kata)){ // aturan  29
					$__kata = preg_replace('/^(peng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
				 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
				 
				if(preg_match('/^(peng)[aiueo]\S{1,}/',$kata)){ // aturan  30
					$__kata = preg_replace('/^(peng)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
				 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(peng)/','k',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(penge)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(peny)[aiueo]\S{1,}/',$kata)){ // aturan  31
					$__kata = preg_replace('/^(peny)/','s',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
		 
				if(preg_match('/^(pel)[aiueo]\S{1,}/',$kata)){ // aturan  32
					$__kata = preg_replace('/^(pel)/','l',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
					 
				if (preg_match('/^(pelajar)\S{0,}/',$kata)){
					$__kata = preg_replace('/^(pel)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(pe)[^rwylmn]er[aiueo]\S{1,}/',$kata)){ // aturan  33
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(pe)[^rwylmn](?!er)\S{1,}/',$kata)){ // aturan  34
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			 
				if(preg_match('/^(pe)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  36
					$__kata = preg_replace('/^(pe)/','',$kata);
					if($this->cekKamus($__kata)){
						return $__kata; // Jika ada balik
					}
					 
					$__kata__ = $this->Del_Derivation_Suffixes($__kata);
					if($this->cekKamus($__kata__)){
						return $__kata__;
					}
				}
			}
		}
		/*------------end pe-, ---------------------------------------------*/

		/*------------ Awalan memper-, ---------------------------------------------*/
		if(preg_match('/^(memper)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(memper)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(memper)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(mempel)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(mempel)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(mempel)/','l',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(menter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(menter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(menter)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(member)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(member)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			//*-- Cek luluh -r ----------
			$__kata = preg_replace('/^(member)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end diper-, ---------------------------------------------*/
		if(preg_match('/^(diper)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diper)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -r ----------*/
			$__kata = preg_replace('/^(diper)','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end diper-, ---------------------------------------------*/
		/*------------end diter-, ---------------------------------------------*/

		if(preg_match('/^(diter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -r ----------*/
			$__kata = preg_replace('/^(diter)','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end diter-, ---------------------------------------------*/
		/*------------end dipel-, ---------------------------------------------*/

		if(preg_match('/^(dipel)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(dipel)/','l',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(dipel)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/*------------end dipel-, ---------------------------------------------*/

		if(preg_match('/^(diber)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(diber)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(diber)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(keber)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(keber)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(keber)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(keter)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(keter)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			/*-- Cek luluh -l----------*/
			$__kata = preg_replace('/^(keter)/','r',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		if(preg_match('/^(berke)\S{1,}/',$kata)){
			$__kata = preg_replace('/^(berke)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		/* --- Cek Ada Tidaknya Prefik/Awalan (di-, ke-, se-, te-, be-, me-, atau pe-) ------*/
		if(preg_match('/^(di|[kstbmp]e)\S{1,}/',$kata) == FALSE){
			return $kataAsal;
		}	 
		return $kataAsal;
	}
		 
		public function proses($kata){
			 
			$kataAsal = $kata;
			 
			/* 1. Cek Kata di Kamus jika Ada SELESAI */
			if($this->cekKamus($kata)){ // Cek Kamus
				return $kata; // Jika Ada kembalikan
			}
			/* 2. Buang Infection suffixes (\-lah", \-kah", \-ku", \-mu", atau \-nya") */
			$kata = $this->Del_Inflection_Suffixes($kata);
			 
			/* 3. Buang Derivation suffix (\-i" or \-an") */
			$kata = $this->Del_Derivation_Suffixes($kata);
			 
			/* 4. Buang Derivation prefix */
			$kata = $this->Del_Derivation_Prefix($kata);
			 
			return $kata;
		}
	}
	
?>







<?php
// 	// class Stemming
// 	// {
// 		// function index() 
// 		// {
// 		// 	$this->load->model('model_stem');
// 		// 	$isi = $this->model_stem->get_all();
// 		// 	$kata = array(
// 		// 		'isi'=> $isi
// 		// 		);
// 		// 	$this->load->view('vclassification',$kata);
// 		// }

// 		function text($data)
// 		{
// 			if (strlen($data <= 2)) {
// 				return $data;
// 			}

// 			$data = self:: hapuspartikel($data);
// 			$data = self:: hapuspp($data);
// 			$data = self:: hapusawalan1($data);
// 			$data = self:: hapusawalan2($data);
// 			$data = self:: hapusakhiran($data);

// 			return $data;
// 		}

// 		//langkah 1 - hapus partikel
// 		function hapuspartikel($data)
// 		{
// 			if(text($data)!=1)
// 			{
// 				if((substr($data, -3) == 'kah' )||( substr($data, -3) == 'lah' )||( substr($data, -3) == 'pun' ))
// 				{
// 					$data = substr($data, 0, -3);			
// 				}
// 			}
// 			return $data;
// 		}

// 		//langkah 2 - hapus possesive pronoun
// 		function hapuspp($data)
// 		{
// 			if(text($data)!=1)
// 			{
// 				if(strlen($data) > 4)
// 				{
// 					if((substr($data, -2)== 'ku')||(substr($data, -2)== 'mu'))
// 					{
// 						$data = substr($data, 0, -2);
// 					}
// 				}
// 				else if((substr($data, -3)== 'nya'))
// 				{
// 					$data = substr($data,0, -3);
// 				}
// 			}
// 			return $data;
// 		}

// 		//langkah 3 hapus first order prefiks (awalan pertama)
// 		function hapusawalan1($data)
// 		{
// 			if(text($data)!=1)
// 			{
// 				if(substr($data,0,4)=="meng")
// 				{
// 					if(substr($data,4,1)=="e"||substr($data,4,1)=="u")
// 					{
// 						$data = "k".substr($data,4);
// 					}
// 					else
// 					{
// 						$data = substr($data,4);
// 					}
// 				}
// 				else if(substr($data,0,4)=="meny")
// 				{
// 					$data = "s".substr($data,4);
// 				}
// 				else if(substr($data,0,3)=="men")
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,3)=="mem"){
// 					if(substr($data,3,1)=="a" || substr($data,3,1)=="i" || substr($data,3,1)=="e" || substr($data,3,1)=="u" || substr($data,3,1)=="o")
// 					{
// 						$data = "p".substr($data,3);
// 					}
// 					else
// 					{
// 						$data = substr($data,3);
// 					}
// 				}
// 				else if(substr($data,0,2)=="me")
// 				{
// 					$data = substr($data,2);
// 				}
// 				else if(substr($data,0,4)=="peng")
// 				{
// 					if(substr($data,4,1)=="e" || substr($data,4,1)=="a")
// 					{
// 						$data = "k".substr($data,4);
// 					}
// 					else
// 					{
// 						$data = substr($data,4);
// 					}
// 				}
// 				else if(substr($data,0,4)=="peny")
// 				{
// 					$data = "s".substr($data,4);
// 				}
// 				else if(substr($data,0,3)=="pen")
// 				{
// 					if(substr($data,3,1)=="a" || substr($data,3,1)=="i" || substr($data,3,1)=="e" || substr($data,3,1)=="u" || substr($data,3,1)=="o")
// 					{
// 						$data = "t".substr($data,3);
// 					}
// 					else
// 					{
// 						$data = substr($data,3);
// 					}
// 				}
// 				else if(substr($data,0,3)=="pem")
// 				{
// 					if(substr($data,3,1)=="a" || substr($data,3,1)=="i" || substr($data,3,1)=="e" || substr($data,3,1)=="u" || substr($data,3,1)=="o")
// 					{
// 						$data = "p".substr($data,3);
// 					}
// 					else
// 					{
// 						$data = substr($data,3);
// 					}
// 				}
// 				else if(substr($data,0,2)=="di")
// 				{
// 					$data = substr($data,2);
// 				}
// 				else if(substr($data,0,3)=="ter")
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,2)=="ke")
// 				{
// 					$data = substr($data,2);
// 				}
// 			}
// 			return $data;
// 		}

// 		//langkah 4 hapus second order prefiks (awalan kedua)
// 		function hapusawalan2($data)
// 		{
// 			if(text($data)!=1)
// 			{
// 				if(substr($data,0,3)=="ber")
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,3)=="bel")
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,2)=="be")
// 				{
// 					$data = substr($data,2);
// 				}
// 				else if(substr($data,0,3)=="per" && strlen($data) > 5)
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,2)=="pe"  && strlen($data) > 5)
// 				{
// 					$data = substr($data,2);
// 				}
// 				else if(substr($data,0,3)=="pel"  && strlen($data) > 5)
// 				{
// 					$data = substr($data,3);
// 				}
// 				else if(substr($data,0,2)=="se"  && strlen($data) > 5)
// 				{
// 					$data = substr($data,2);
// 				}
// 			}
// 			return $data;
// 		}

// 		////langkah 5 hapus suffiks
// 		function hapusakhiran($data)
// 		{
// 			if(text($data)!=1)
// 			{
// 				if (substr($data, -3)== "kan" )
// 				{
// 					$data = substr($data, 0, -3);
// 				}
// 				else if(substr($data, -1)== "i" )
// 				{
// 				    $data = substr($data, 0, -1);
// 				}
// 				else if(substr($data, -2)== "an")
// 				{
// 					$data = substr($data, 0, -2);
// 				}
// 			}	
// 			return $data;
// 		}
// 	// }

// ?>





<?php
// 	// $conn = mysql_connect("localhost","root","");
// 	// if (!$conn) die ("Koneksi gagal");
// 	// mysql_select_db("db",$conn) or die ("Database tidak ditemukan");

// 	// include "stemming.php";

// 	// class Preprocessing
// 	// {
// 	// 	protected $this;
// 	// 	private $stopwords2 = array("a", "about", "above", "acara", "across", "ada", "adalah", "adanya", "after", "afterwards", "again", "against", "agar", "akan", "akhir", "akhirnya", "akibat", "aku", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "anda", "another", "antara", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "apa", "apakah", "apalagi", "are", "around", "as", "asal", "at", "atas", "atau", "awal", "b", "back", "badan", "bagaimana", "bagi", "bagian", "bahkan", "bahwa", "baik", "banyak", "barang", "barat", "baru", "bawah", "be", "beberapa", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begitu", "behind", "being", "belakang", "below", "belum", "benar", "bentuk", "berada", "berarti", "berat", "berbagai", "berdasarkan", "berjalan", "berlangsung", "bersama", "bertemu", "besar", "beside", "besides", "between", "beyond", "biasa", "biasanya", "bila", "bill", "bisa", "both", "bottom", "bukan", "bulan", "but", "by", "call", "can", "cannot", "cant", "cara", "co", "con", "could", "couldnt", "cry", "cukup", "dalam", "dan", "dapat", "dari", "datang", "de", "dekat", "demikian", "dengan", "depan", "describe", "detail", "di", "dia", "diduga", "digunakan", "dilakukan", "diri", "dirinya", "ditemukan", "do", "done", "down", "dua", "due", "dulu", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empat", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "gedung", "get", "give", "go", "had", "hal", "hampir", "hanya", "hari", "harus", "has", "hasil", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "hidup", "him", "himself", "hingga", "his", "how", "however", "hubungan", "hundred", "ia", "ie", "if", "ikut", "in", "inc", "indeed", "ingin", "ini", "interest", "into", "is", "it", "its", "itself", "itu", "jadi", "jalan", "jangan", "jauh", "jelas", "jenis", "jika", "juga", "jumat", "jumlah", "juni", "justru", "juta", "kalau", "kali", "kami", "kamis", "karena", "kata", "katanya", "ke", "kebutuhan", "kecil", "kedua", "keep", "kegiatan", "kehidupan", "kejadian", "keluar", "kembali", "kemudian", "kemungkinan", "kepada", "keputusan", "kerja", "kesempatan", "keterangan", "ketiga", "ketika", "khusus", "kini", "kita", "kondisi", "kurang", "lagi", "lain", "lainnya", "lalu", "lama", "langsung", "lanjut", "last", "latter", "latterly", "least", "lebih", "less", "lewat", "lima", "ltd", "luar", "made", "maka", "mampu", "mana", "mantan", "many", "masa", "masalah", "masih", "masing-masing", "masuk", "mau", "maupun", "may", "me", "meanwhile", "melakukan", "melalui", "melihat", "memang", "membantu", "membawa", "memberi", "memberikan", "membuat", "memiliki", "meminta", "mempunyai", "mencapai", "mencari", "mendapat", "mendapatkan", "menerima", "mengaku", "mengalami", "mengambil", "mengatakan", "mengenai", "mengetahui", "menggunakan", "menghadapi", "meningkatkan", "menjadi", "menjalani", "menjelaskan", "menunjukkan", "menurut", "menyatakan", "menyebabkan", "menyebutkan", "merasa", "mereka", "merupakan", "meski", "might", "milik", "mill", "mine", "minggu", "misalnya", "more", "moreover", "most", "mostly", "move", "much", "mulai", "muncul", "mungkin", "must", "my", "myself", "nama", "name", "namely", "namun", "nanti", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "oleh", "on", "once", "one", "only", "onto", "or", "orang", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "pada", "padahal", "pagi", "paling", "panjang", "para", "part", "pasti", "pekan", "penggunaan", "penting", "per", "perhaps", "perlu", "pernah", "persen", "pertama", "pihak", "please", "posisi", "program", "proses", "pula", "pun", "punya", "put", "rabu", "rasa", "rather", "re", "ribu", "ruang", "saat", "sabtu", "saja", "salah", "sama", "same", "sampai", "sangat", "satu", "saya", "sebab", "sebagai", "sebagian", "sebanyak", "sebelum", "sebelumnya", "sebenarnya", "sebesar", "sebuah", "secara", "sedang", "sedangkan", "sedikit", "see", "seem", "seemed", "seeming", "seems", "segera", "sehingga", "sejak", "sejumlah", "sekali", "sekarang", "sekitar", "selain", "selalu", "selama", "selasa", "selatan", "seluruh", "semakin", "sementara", "sempat", "semua", "sendiri", "senin", "seorang", "seperti", "sering", "serious", "serta", "sesuai", "setelah", "setiap", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "suatu", "such", "sudah", "sumber", "system", "tahu", "tahun", "tak", "take", "tampil", "tanggal", "tanpa", "tapi", "telah", "teman", "tempat", "ten", "tengah", "tentang", "tentu", "terakhir", "terhadap", "terjadi", "terkait", "terlalu", "terlihat", "termasuk", "ternyata", "tersebut", "terus", "terutama", "tetapi", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "tidak", "tiga", "tinggal", "tinggi", "tingkat", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "ujar", "umum", "un", "under", "until", "untuk", "up", "upaya", "upon", "us", "usai", "utama", "utara", "very", "via", "waktu", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "wib", "will", "with", "within", "without", "would", "ya", "yaitu", "yakni", "yang", "yet", "you", "your", "yours", "yourself", "yourselves");

// 	// 	// public function index(){
// 	// 	// 	// $this->load->model('vpre_baru');
// 	// 	// 	// $konten=$this->vpre_baru->get_all();
			
// 	// 	// 	// $text= array(
// 	// 	// 	// 	'konten'=>$konten
// 	// 	// 	// 	);
// 	// 	// 	// $this->load->view('view_berita',$text);
// 	// 	// }

// 	// 	public function text()
// 	// 	{
// 	// 		$select = mysql_query("SELECT * from berita_baru");
// 	// 		while ($data = mysql_fetch_array($select)) {
// 	// 			$text = $data['isi_berita'];
// 	// 		}
// 	// 		return $text;
// 	// 	}

// 	// 	public function pecah_kalimat($text) //no $text
// 	// 	{
// 	// 		$pecah = explode(".",$text);
// 	// 		return $pecah;
// 	// 	}

// 	// 	public function case_folding($text)
// 	// 	{
// 	// 		$looping_data = $this->pecah_kalimat($text);
// 	// 		foreach ($looping_data as $key => $value) 
// 	// 		{
// 	// 			$input = preg_replace('@[?:;,."/\'+-=!~#()0-9]+@', " ", strtolower($value));
// 	// 			$data[] = $input;
// 	// 		}
// 	// 		return $data;
// 	// 	}

// 	// 	public function tokenizing($text)
// 	// 	{
// 	// 		// $data = $this->case_folding($text);
// 	// 		// foreach ($data as $key => $values) 
// 	// 		// {
// 	// 		// 	$case[] = explode(" ", $values);
// 	// 		// }
// 	// 		// foreach ($case as $key => $value) 
// 	// 		// {
// 	// 		// 	$response[] = $value;
// 	// 		// }
// 	// 		// return $response;
// 	// 		$data = str_word_count($text, 1); 
// 	// 		$count = count($data);
// 	// 		// return $data;

// 	// 		array_walk($data, array($this, 'filter'));
// 	// 		$data = array_diff($data, $this->stopwords2);
// 	// 		$wordCount = array_count_values($data);
// 	// 		// arsort($wordCount);

// 	// 		$jumlahFilter = count($wordCount);

// 	// 		return array_keys($wordCount);
// 	// 	}

// 	// 	private function filter($wordCount)
// 	// 	{
// 	// 		$wordCount = strtolower($wordCount);
// 	// 	}

// 	// 	// public function filtering($kalimat) 
// 	// 	// {
// 	// 	// 	// menghilangkan array yang sama
// 	// 	// 	$data = $this->tokenizing($kalimat);
// 	// 	// 	foreach ($data as $key => $value) 
// 	// 	// 	{
// 	// 	// 		$index_array = $this->array_empty_remover($value);
// 	// 	// 		// $uniq = array_unique($index_array);
// 	// 	// 		$filtering[] = $index_array; // array_merge($uniq);
// 	// 	// 	}
// 	// 	// 	return $filtering;
// 	// 	// }

// 	// 	// public function stopword($array_kalimat, $array_stopword)
// 	// 	// {
// 	// 	// 	return str_replace($array_stopword, " ", $array_kalimat);
// 	// 	// }

// 	// 	// public function array_empty_remover($array, $remove_null_number = TRUE)
// 	// 	// {
// 	// 	// 	$array_remove = array(
// 	// 	// 			"a", "about", "above", "acara", "across", "ada", "adalah", "adanya", "after", "afterwards", "again", "against", "agar", "akan", "akhir", "akhirnya", "akibat", "aku", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "amoungst", "amount", "an", "and", "anda", "another", "antara", "any", "anyhow", "anyone", "anything", "anyway", "anywhere", "apa", "apakah", "apalagi", "are", "around", "as", "asal", "at", "atas", "atau", "awal", "b", "back", "badan", "bagaimana", "bagi", "bagian", "bahkan", "bahwa", "baik", "banyak", "barang", "barat", "baru", "bawah", "be", "beberapa", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begitu", "behind", "being", "belakang", "below", "belum", "benar", "bentuk", "berada", "berarti", "berat", "berbagai", "berdasarkan", "berjalan", "berlangsung", "bersama", "bertemu", "besar", "beside", "besides", "between", "beyond", "biasa", "biasanya", "bila", "bill", "bisa", "both", "bottom", "bukan", "bulan", "but", "by", "call", "can", "cannot", "cant", "cara", "co", "con", "could", "couldnt", "cry", "cukup", "dalam", "dan", "dapat", "dari", "datang", "de", "dekat", "demikian", "dengan", "depan", "describe", "detail", "di", "dia", "diduga", "digunakan", "dilakukan", "diri", "dirinya", "ditemukan", "do", "done", "down", "dua", "due", "dulu", "during", "each", "eg", "eight", "either", "eleven", "else", "elsewhere", "empat", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "gedung", "get", "give", "go", "had", "hal", "hampir", "hanya", "hari", "harus", "has", "hasil", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "hidup", "him", "himself", "hingga", "his", "how", "however", "hubungan", "hundred", "ia", "ie", "if", "ikut", "in", "inc", "indeed", "ingin", "ini", "interest", "into", "is", "it", "its", "itself", "itu", "jadi", "jalan", "jangan", "jauh", "jelas", "jenis", "jika", "juga", "jumat", "jumlah", "juni", "justru", "juta", "kalau", "kali", "kami", "kamis", "karena", "kata", "katanya", "ke", "kebutuhan", "kecil", "kedua", "keep", "kegiatan", "kehidupan", "kejadian", "keluar", "kembali", "kemudian", "kemungkinan", "kepada", "keputusan", "kerja", "kesempatan", "keterangan", "ketiga", "ketika", "khusus", "kini", "kita", "kondisi", "kurang", "lagi", "lain", "lainnya", "lalu", "lama", "langsung", "lanjut", "last", "latter", "latterly", "least", "lebih", "less", "lewat", "lima", "ltd", "luar", "made", "maka", "mampu", "mana", "mantan", "many", "masa", "masalah", "masih", "masing-masing", "masuk", "mau", "maupun", "may", "me", "meanwhile", "melakukan", "melalui", "melihat", "memang", "membantu", "membawa", "memberi", "memberikan", "membuat", "memiliki", "meminta", "mempunyai", "mencapai", "mencari", "mendapat", "mendapatkan", "menerima", "mengaku", "mengalami", "mengambil", "mengatakan", "mengenai", "mengetahui", "menggunakan", "menghadapi", "meningkatkan", "menjadi", "menjalani", "menjelaskan", "menunjukkan", "menurut", "menyatakan", "menyebabkan", "menyebutkan", "merasa", "mereka", "merupakan", "meski", "might", "milik", "mill", "mine", "minggu", "misalnya", "more", "moreover", "most", "mostly", "move", "much", "mulai", "muncul", "mungkin", "must", "my", "myself", "nama", "name", "namely", "namun", "nanti", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "oleh", "on", "once", "one", "only", "onto", "or", "orang", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own", "pada", "padahal", "pagi", "paling", "panjang", "para", "part", "pasti", "pekan", "penggunaan", "penting", "per", "perhaps", "perlu", "pernah", "persen", "pertama", "pihak", "please", "posisi", "program", "proses", "pula", "pun", "punya", "put", "rabu", "rasa", "rather", "re", "ribu", "ruang", "saat", "sabtu", "saja", "salah", "sama", "same", "sampai", "sangat", "satu", "saya", "sebab", "sebagai", "sebagian", "sebanyak", "sebelum", "sebelumnya", "sebenarnya", "sebesar", "sebuah", "secara", "sedang", "sedangkan", "sedikit", "see", "seem", "seemed", "seeming", "seems", "segera", "sehingga", "sejak", "sejumlah", "sekali", "sekarang", "sekitar", "selain", "selalu", "selama", "selasa", "selatan", "seluruh", "semakin", "sementara", "sempat", "semua", "sendiri", "senin", "seorang", "seperti", "sering", "serious", "serta", "sesuai", "setelah", "setiap", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "suatu", "such", "sudah", "sumber", "system", "tahu", "tahun", "tak", "take", "tampil", "tanggal", "tanpa", "tapi", "telah", "teman", "tempat", "ten", "tengah", "tentang", "tentu", "terakhir", "terhadap", "terjadi", "terkait", "terlalu", "terlihat", "termasuk", "ternyata", "tersebut", "terus", "terutama", "tetapi", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "tidak", "tiga", "tinggal", "tinggi", "tingkat", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "ujar", "umum", "un", "under", "until", "untuk", "up", "upaya", "upon", "us", "usai", "utama", "utara", "very", "via", "waktu", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "wib", "will", "with", "within", "without", "would", "ya", "yaitu", "yakni", "yang", "yet", "you", "your", "yours", "yourself", "yourselves"
//  //  //  				);
// 	// 	// }

// 	// 	public function stemming($word) {
// 	// 		/*$stem = NaziefStemmer::Stem($word);
// 	// 		return $stem;*/
// 	// 	}
// 	// }
			
// 	// $ir = new Preprocessing;
// 	// $select = mysql_query("SELECT * from berita_baru");
// 	// while ($data = mysql_fetch_array($select)) {
// 	// 	$text = $data['isi_berita'];
// 	// 	$pecah = $ir->case_folding($text);
// 	// 	foreach ($pecah as $key => $hasil) {
// 	// 		// echo "$key : $hasil";echo "<br>";
// 	// 		$word = str_word_count($hasil, 1); 
// 	// 		$jumlah = count($word);
// 	// 		// echo $jumlah."<br>";
			
// 	// 		foreach ($ir->tokenizing($hasil) as $value) {
// 	// 			echo $value."<br>";
// 	// 		}
// 	// 		echo "<br><br>";
// 	// 	}
// 	// 	echo "<br><br>";
// 	// }

// // $kalimat = "Idul Fitri adalah hal yang dinanti-nantikan oleh umat muslim setiap tahunnya. Tak perduli jarak, 
// // 	waktu, hingga uang, akan dikorbankan agar bisa menghabiskan lebaran untuk mudik berkumpul dengan keluarga. 
// // 	Termasuk rela berjam-jam terperangkap macet. Hal ini seperti yang dirasakan oleh Firman Abielfida, 
// // 	pemudik dari Purwakarta yang hendak menuju kampung halamannya di Semarang. Berangkat bersama sang adik sejak pukul 15.00 WIB, Sabtu (2/7/2015), 
// // 	hingga saat ini Firman masih jauh dari tujuan dan terjebak macet di wilayah Brebes. Saya sekarang di wilayah Bangsri. 
// // 	Lalu lintas Brebes-Tegal nyaris parkir, ujar Firman saat berbincang dengan detikcom, Minggu (3/7/2016). Perjalanan Firman pada awalnya cukup lancar. 
// // 	Ia keluar dari Tol Palimanan saat magrib dan terus melanjutkan hingga Kanci. Sampai di daerah Bulakamba, 
// // 	bapak dua anak ini lalu beristirahat untuk makan. Setelah istirahat sebentar dan hendak melanjutkan perjalanan, Firman terjebak macet parah. 
// // 	Bulakamba menuju Bangsri sebenarnya hanya berjarak lebih kurang 10 km tetapi dari jam 20.05 WIB sampai dengan saat ini situasi masih sama dan stagnan, 
// // 	kata dia. Beruntung Firman sudah terlebih dahulu memulangkan istri dan anak-anaknya ke kampung halaman mereka. 
// // 	Ia tidak ingin buah hatinya yang masih kecil-kecil harus merasakan beratnya perjuangan mudik lewat jalur darat. Karena situasinya kayak gini, 
// // 	kasihan kalau ikut saya. Udah seminggu lalu istri dan anak-anak saya pulangin duluan naik kereta. Kalau saya bawa mobil karena di sana bisa dipakai juga, 
// // 	tutur Firman. Meski harus berpeluh setiap tahun menghadapi kemacetan arus mudik, Firman tak menyerah. 
// // 	Tetap saja perjuangan itu ia lakoni demi berkumpul bersama keluarga, terutama agar bisa menghadap orangtua. Mau ke rumah orangtua. 
// // 	Alhamdulillah orangtua saya masih lengkap. Nggak apa-apa macet-macetan, setahun sekali. Yang paling penting bisa lebaran sama orangtua dan istri anak, 
// // 	sebutnya. Pengalaman mudik tahun ini menurut Firman adalah yang paling parah dari empat tahun pengalaman mudiknya. 
// // 	Itu bisa terlihat dari bagaimana jarak Bulukamba-Bangsri yang hanya 10 km perlu ditempuhnya selama lebih dari 10 jam. 
// // 	Dan ia masih harus menghadapi kemacetan entah hingga pukul berapa dan tak bisa memprediksi kapan akan sampai Semarang. 
// // 	Paling parah kayaknya tahun ini. Tahun kemarin saya 36 jam baru sampai, sekarang nggak tahu deh. Bisa-bisa besok baru sampai kayaknya, 
// // 	apalagi Pekalongan katanya juga macet, ucap Firman. Menurutnya, saat ini 4 lajur baik sisi kiri dan kanan Pantura sudah terpakai semua oleh para pemudik 
// // 	yang hendak menuju timur. Itu dikatakan Firman menambah kekacauan. Rombongan pemudik motor mulai berdatangan dari jam 03.00 WIB. 
// // 	Ini nggak jalan sama sekali. Sebelum 4 lajur kepakai semua, masih jalan sedikit. Sekarang nggak sama sekali, terangnya. Walau terjebak kemacetan cukup parah, 
// // 	tampaknya ia bersama sang adik tetap semangat mudik ke kampung halaman. Ya dijalani aja, tutup Firman sambil tergelak.";

?>