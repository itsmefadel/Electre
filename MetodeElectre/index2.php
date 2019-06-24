<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    <?php include("koneksi.php"); ?>
    
</head>
    <body>
        <ul>
        <li><a href="index.php">Input Alternatif</a></li>
        <li><a href="index2.php">Kalkulasi Alternatif</a></li>
        </ul>
        <?php $namaBarangTanpaBobot=array();
        $arraySoal=array();
        $arrayConcordance=array();
        $arrayDisordance=array();
        $arrayMatriksDominanConcordance=array();
        $arrayMatriksDominanDisordance=array();
        $arrayAgregatDominanceMatriks=array();
        $statusInputan=false; ?>
      <table border="1" style="width:30%">
          <h1>KALKULASI ALTERNATIF</h1>
          <tr>          
              <td>NAMA ALTERNATIF</td>
              <td>HARGA</td>
              <td>KUALITAS</td>
              <td>FITUR</td>
              <td>POPULER</td>
              <td>KEAWETAN</td>
          </tr>
          <?php $query="Select * from alternatiff";
          $hasil=mysqli_query($koneksi,$query);           
          $i=0;
          while($data=mysqli_fetch_array($hasil, MYSQLI_ASSOC)){
              
          ?>
          <tr>
              <td><?php echo $namaBarangTanpaBobot[$i]=$data['namaAlternatif'] ?></td>
              <td><?php echo $arraySoal[$i][0]=$data['harga'] ?></td>
              <td><?php echo $arraySoal[$i][1]=$data['kualitas'] ?></td>
              <td><?php echo $arraySoal[$i][2]=$data['fitur'] ?></td>
              <td><?php echo $arraySoal[$i][3]=$data['populer'] ?></td>
              <td><?php echo $arraySoal[$i][4]=$data['keawetan'] ?></td>
          </tr> 
          <?php $i++; } ?>
      </table>
        
        <?php 
        //$arraySoal=deklarasiArrayAwal($arraySoal);
        //$namaBarangTanpaBobot=array("Galaxy","Iphone","Blackb");
        //$namaBarangTanpaBobot=inisialisasiBarang();
        //if(isset($namaBarangTanpaBobot)){
        $namaBarang=$namaBarangTanpaBobot;
        $namaBarang[count($namaBarang)]="Bobbot";
        //$namaBarang[count($namaBarang)+1]=count($namaBarang)+1
        //$namaBarang=$namaBarangTanpaBobot."Bobbot";
        $kriteriaBarang=array("Harga","Kualitas","Desain Interior","Populer","Keawetan");
        //$arraySoal=testing($arraySoal);
        //$arraySoal=awal($arraySoal);
        $banyakAlternatif=$i+1;
        $arraySoal=testingBobot($arraySoal);
        //$arraySoal=inputBobot($arraySoal);
        //if(isset($_REQUEST['uploadFile'])){
        echo "<br>"."MATRIX SOAL:=>"."<br>";
        printArray4($arraySoal);
        $arrayXDataNilai=$arraySoal;
        $arrayXDataNilai=xDataNilai($arraySoal,$arrayXDataNilai);
        echo "<br>"."MATIRX X (Data Nilai)"."<br>";
        printArray4($arrayXDataNilai);
        $arrayRNormalisasi=$arraySoal;
        $arrayRNormalisasi=rNormalisasi($arrayXDataNilai,$arrayRNormalisasi);
        echo "<br>"."MATIRX R Normalisasi"."<br>";
        printArray4($arrayRNormalisasi);
        $arrayV=$arraySoal;
        $arrayV=tabelV($arrayV,$arrayRNormalisasi);
        echo "<br>"."MATIRX V (NORMALISASI * BOBOT)"."<br>";
        printArray4($arrayV);
        $arrayConcordance=deklarasiArray3x3($arrayConcordance);
        $arrayConcordance=tabelConcordance($arrayConcordance,$arrayV);
            
        echo "<br>"."TABEL CONCORDANCE"."<br>";
        printArray3x3($arrayConcordance);
        $arrayDisordance=deklarasiArray3x3($arrayDisordance);
        $arrayDisordance=tabelDisordance($arrayDisordance,$arrayV);
        echo "TABEL DISORDANCE"."<br>";
        printArray3x3($arrayDisordance);
        $arrayMatriksConcordance=$arrayConcordance;
        $arrayMatriksConcordance=matriksConcordance($arrayMatriksConcordance,$arrayV,$arraySoal);
        echo "TABEL MATRIKS CONCORDANCE"."<br>";
        printArray3x3($arrayMatriksConcordance);
        $arrayMatriksDisordance=$arrayDisordance;
        $arrayMatriksDisordance=matriksDisordance($arrayMatriksDisordance,$arrayV);
        echo "TABEL MATRIKS DISORDANCE"."<br>";
        printArray3x3($arrayMatriksDisordance);
        $tresholdConcordance=tresholdConcordance($arrayMatriksConcordance);
        echo "TRESHOLD CONCORDANCE"."<br>".$tresholdConcordance."<br>";
        $tresholdDisordance=tresholdDisordance($arrayMatriksDisordance);
        echo "TRESHOLD DISORDANCE"."<br>".$tresholdDisordance."<br>"."<br>";
 $arrayMatriksDominanConcordance=matriksDominanConcordance($arrayMatriksDominanConcordance,$tresholdConcordance,$arrayMatriksConcordance);
        echo "MATRIKS DOMINAN CONCORDANCE"."<br>";
        printArray3x3($arrayMatriksDominanConcordance);
 $arrayMatriksDominanDisordance=matriksDominanConcordance($arrayMatriksDominanDisordance,$tresholdDisordance,$arrayMatriksDisordance);
        echo "MATRIKS DOMINAN DISORDANCE"."<br>";
        printArray3x3($arrayMatriksDominanDisordance);
$arrayAgregatDominanceMatriks=agregatDominanceMatriks($arrayAgregatDominanceMatriks,$arrayMatriksDominanConcordance,$arrayMatriksDominanDisordance);
    echo "AGREGATE DOMINANCE MATRIKS"."<br>";
        printArray3x3($arrayAgregatDominanceMatriks);
        echo "PILIHAN YANG PALING OPTIMAL ADALAH :"."<br>";
        $jawaban=perangkingan($arrayAgregatDominanceMatriks);
            if($jawaban==10){echo "Tidak ada alternatif yang sesuai";}else{
            
        echo "Nama Alternatif= ".$namaBarang[$jawaban];  }
        //}
        //}
        ?>
        
        <?php
        function testingBobot($arraySoal){
            global $i;
            $arraySoal[$i][0]="5";
            $arraySoal[$i][1]="3";                            
            $arraySoal[$i][2]="4";
            $arraySoal[$i][3]="4";
            $arraySoal[$i][4]="2";                            
            return $arraySoal;  
        }
        ?>
            
        <?php
        function testing($arraySoal){
            $arraySoal[0][0]=4;
            $arraySoal[0][1]=4;
            $arraySoal[0][2]=5;
            $arraySoal[0][3]=3;
            $arraySoal[0][4]=3;
            $arraySoal[1][0]=3;
            $arraySoal[1][1]=3;
            $arraySoal[1][2]=4;
            $arraySoal[1][3]=2;
            $arraySoal[1][4]=3;
            $arraySoal[2][0]=5;
            $arraySoal[2][1]=4;
            $arraySoal[2][2]=2;
            $arraySoal[2][3]=2;
            $arraySoal[2][4]=2;
            $arraySoal[3][0]=5;
            $arraySoal[3][1]=3;
            $arraySoal[3][2]=4;
            $arraySoal[3][3]=4;
            $arraySoal[3][4]=2;
        return $arraySoal;}
        ?>
        <?php 
        function inputBobot($arraySoal){ ?>
            <form method="post" enctype="multipart/form-data">
            <h2>Input Bobot Kriteria</h2>
            <ul>
            <li><label for="fileSelect">Harga:</label>
            <input type="text" name="bobotHarga" id="bobotHarga"><br></li>
            <li><label for="fileSelect">Kualitas:</label>
            <input type="text" name="bobotKualitas" id="bobotKualitas" ><br></li>
            <li><label for="fileSelect">Fitur:</label>
            <input type="text" name="bobotFitur" id="bobotFitur"><br></li>
            <li><label for="fileSelect">Populer:</label>
            <input type="text" name="bobotPopuler" id="bobotPopuler"><br></li>
            <li><label for="fileSelect">Keawetan:</label>
            <input type="text" name="bobotKeawetan" id="bobotKeawetan"><br></li>
            </ul>
            <input type="submit" name="uploadFile" value="Tambah" id="uploadFile">
            <br>
            </form>
            
        <?php 
            if(isset($_POST['uploadFile'])){
              $bobotHarga=$_POST['bobotHarga'];
              $bobotKualitas=$_POST['bobotKualitas'];
              $bobotFitur=$_POST['bobotFitur'];
              $bobotPopuler=$_POST['bobotPopuler'];
              $bobotKeawetan=$_POST['bobotKeawetan'];
            global $i;
            $arraySoal[$i][0]=$bobotHarga;
            $arraySoal[$i][1]=$bobotKualitas;                            
            $arraySoal[$i][2]=$bobotFitur;
            $arraySoal[$i][3]=$bobotPopuler;
            $arraySoal[$i][4]=$bobotKeawetan;                            
                                       $i++;}
            return $arraySoal;}
        
        
        ?>
        
        <?php
        function deklarasiArrayAwal($arraySoal){
            for($i=0;$i<4;$i++){
               for($j=0;$j<5;$j++){
                 $arraySoal[$i][$j]="-";
            }}return $arraySoal;}
        ?>
        
         <?php
        function deklarasiArray3x3($arraySoal){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif;$i++){
               for($j=0;$j<$banyakAlternatif;$j++){
                 $arraySoal[$i][$j]="-";
            }}return $arraySoal;}
        ?>
        
        <?php
        function inisialisasiBarang(){ ?>
            <form method="post" enctype="multipart/form-data">
            <h2>Input Bobot Kriteria</h2>
            <?php for($barisKe=0;$barisKe<3;$barisKe++){ ?>
            <ul>
            <?php global $namaBarangTanpaBobot;
            ?>
            <li><label for="NamaAlternatif">Alternatif <?php echo $barisKe+1; ?></label>
            <input type="text" name="NamaAlternatif<?php echo $barisKe; ?>" id="NamaAlternatif"><br></li>
            </ul>
            <?php } ?>
            <input type="submit" name="inputAlternatif" value="input Alternatif" id="inputAlternatif">
            <br>
            </form>
        
        <?php
            if(isset($_REQUEST['inputAlternatif'])){
             for($i=0;$i<$barisKe;$i++){
                 $namaBarangTanpaBobot[$i]=$_POST['NamaAlternatif'.$i];
            }
            return $namaBarangTanpaBobot;} 
                                               }
        ?>
        
        <?php
        function awal($arraySoal){ ?>
            <form method="post" enctype="multipart/form-data">
            <h2>Input Bobot Kriteria</h2>
            <?php for($barisKe=0;$barisKe<4;$barisKe++){ ?>
            <ul>
            <?php global $namaBarang;
            echo "Nama Barang = ".$namaBarang[$barisKe]; ?>
            <li><label for="fileSelect">Harga:</label>
            <input type="text" name="kriteriaHarga<?php echo $barisKe; ?>" id="kriteriaHarga"><br></li>
            <li><label for="fileSelect">Kualitas:</label>
            <input type="text" name="kriteriaKualitas<?php echo $barisKe; ?>" id="kriteriaKualitas" ><br></li>
            <li><label for="fileSelect">Fitur:</label>
            <input type="text" name="kriteriaFitur<?php echo $barisKe; ?>" id="kriteriaFitur"><br></li>
            <li><label for="fileSelect">Populer:</label>
            <input type="text" name="kriteriaPopuler<?php echo $barisKe; ?>" id="kriteriaPopuler"><br></li>
            <li><label for="fileSelect">Keawetan:</label>
            <input type="text" name="kriteriaKeawetan<?php echo $barisKe; ?>" id="kriteriaKeawetan"><br></li>
            </ul>
            <?php } ?>
            <input type="submit" name="uploadFile" value="input kan" id="uploadFile">
            <br>
            </form>
        
        <?php
            if(isset($_REQUEST['uploadFile'])){
            for($barisKe=0;$barisKe<4;$barisKe++){
            $arraySoal[$barisKe][0]=intval($_POST['kriteriaHarga'.$barisKe]);
            $arraySoal[$barisKe][1]=intval($_POST['kriteriaKualitas'.$barisKe]);
            $arraySoal[$barisKe][2]=intval($_POST['kriteriaFitur'.$barisKe]);
            $arraySoal[$barisKe][3]=intval($_POST['kriteriaPopuler'.$barisKe]);
            $arraySoal[$barisKe][4]=intval($_POST['kriteriaKeawetan'.$barisKe]);}
             $statusInputan=true;}return $arraySoal;} 
        ?>
        
        <?php
        function printArray5x4($printArray){
            global $banyakAlternatif;
            ?>
        <tabel style="width:50%">
        <?php
            echo "Alternatif"." |";
            global $kriteriaBarang;global $namaBarang;
            for($i=0;$i<5;$i++){         
                echo " ".$kriteriaBarang[$i]." ";}
            echo "<br>";
            for($i=0;$i<$banyakAlternatif;$i++){ ?>
            <tr>
                <td> <?php echo $namaBarang[$i]; ?></td>
               <?php echo "| ";
               for($j=0;$j<5;$j++){ ?>
                <td>
                <?php echo $printArray[$i][$j]."  ";  ?> </td><?php }
                echo " |";
                echo "<br>";}echo "<br>"; ?>
            </tr>
                 </tabel> <?php } ?>
        
        <?php
        function printArray4($printArray){
            ?>
        <tabel style="width:50%">
             <tr>
                 <td>ALTERNATIF |</td>
        <?php
            
           // echo "Alternatif"." |";
            global $kriteriaBarang;global $namaBarang;
            global $banyakAlternatif;
            for($i=0;$i<5;$i++){ ?>
            <td><?php echo $kriteriaBarang[$i]; ?></td><?php } ?>
             <br>
            </tr>
            <?php
            for($i=0;$i<$banyakAlternatif;$i++){ ?>
            <tr>
            <td><?php echo $namaBarang[$i]; ?> |</td>
               <?php 
               for($j=0;$j<5;$j++){ ?>
                <td>
                <?php echo " ' ".$printArray[$i][$j]." ' ";  ?> 
                </td>
                <?php }
                //echo " |";
                //echo "<br>";}echo "<br>"; 
                ?>
            </tr> <br>
            <?php } ?>
                 </tabel> <?php } ?>
    
        
        <?php
        function printArray3x3($printArray){
            echo "Alternatif"." |";
            global $namaBarang;
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                echo " ".$namaBarang[$i]." ";}
            echo "<br>";
            for($i=0;$i<$banyakAlternatif-1;$i++){    
                echo $namaBarang[$i];
                echo "| ";
               for($j=0;$j<$banyakAlternatif-1;$j++){
                   if($i==$j){$printArray[$i][$j]="-";}
                echo "' ".$printArray[$i][$j]." ' ";}
                echo " |";
                echo "<br>";}echo "<br>";}
        ?>
            
        <?php
        function xDataNilai($arraySoal,$arrayXDataNilai){
            global $banyakAlternatif;
            for($i=0;$i<5;$i++){
                 $arrayXDataNilai[$banyakAlternatif-1][$i]=0;
                for($j=0;$j<$banyakAlternatif-1;$j++){
          $arrayXDataNilai[$banyakAlternatif-1][$i]=($arraySoal[$j][$i]*$arraySoal[$j][$i])+$arrayXDataNilai[$banyakAlternatif-1][$i];
                }$arrayXDataNilai[$banyakAlternatif-1][$i]=sqrt($arrayXDataNilai[$banyakAlternatif-1][$i]);
            }
            return $arrayXDataNilai;
        }
        ?>
        
        <?php
        function rNormalisasi($arrayXDataNilai,$arrayRNormalisasi){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
            for($j=0;$j<5;$j++){
                if($arrayRNormalisasi[$i][$j]==0){
                     $arrayRNormalisasi[$i][$j]="0";
                }else{
                $arrayRNormalisasi[$i][$j]=$arrayRNormalisasi[$i][$j]/$arrayXDataNilai[$banyakAlternatif-1][$j];
                }
            }}
        return $arrayRNormalisasi;
        }
        ?>
        
        <?php
        function tabelV($arrayV,$arrayRNormalisasi){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
            for($j=0;$j<5;$j++){
                $arrayV[$i][$j]=$arrayRNormalisasi[$i][$j]*$arrayV[$banyakAlternatif-1][$j];
            }}
            
        return $arrayV;}
        ?>
        
        <?php
        function tabelConcordance($arrayConcordance,$arrayV){
            global $banyakAlternatif;
            /*$baris=0;
            $kolom=1;
            for($kolom=0;$kolom<3;$kolom++){
            //galaxy terhadap iphone
            $arrayConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i;
                }else{
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i.",";}}
            }}
            */
            for($baris=0;$baris<$banyakAlternatif;$baris++){
            for($kolom=0;$kolom<$banyakAlternatif;$kolom++){
            if($baris==$kolom){$arrayConcordance[$baris][$kolom]=" ";}
            else{
            $arrayConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i;
                }else{
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i.",";}}
            }}}}
            
            
            //kolom++
           /*
            //galaxy terhadap BB
            $arrayConcordance[$baris][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[2][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[$baris][2]=$arrayConcordance[$baris][2].$i;
                }else{
                $arrayConcordance[$baris][2]=$arrayConcordance[$baris][2].$i.",";}}
            }
            
            $baris=1;
            $kolom=0;
            for($kolom=0;$kolom<3;$kolom++){
            //Iphone terhadap Galaxy
            $arrayConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i;
                }else{
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i.",";}}
            }
            }
           
            
            //Iphone terhadap Galaxy
            $arrayConcordance[1][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]>=$arrayV[0][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[1][0]=$arrayConcordance[1][0].$i;
                }else{
                $arrayConcordance[1][0]=$arrayConcordance[1][0].$i.",";}}
            }
            //Iphone terhadap BB
            $arrayConcordance[1][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]>=$arrayV[2][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[1][2]=$arrayConcordance[1][2].$i;
                }else{
                $arrayConcordance[1][2]=$arrayConcordance[1][2].$i.",";}}
            }
            
            //BB terhadap Galaxy
            $arrayConcordance[2][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]>=$arrayV[0][$j]){
                $i=$j+1;
                if($j==5){
                $arrayConcordance[2][0]=$arrayConcordance[2][0].$i;
                }else{
                $arrayConcordance[2][0]=$arrayConcordance[2][0].$i.",";}}
            }
            //BB terhadap Iphone
            $arrayConcordance[2][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]>=$arrayV[1][$j]){
                $i=$j+1;
                if($j==5){
                $arrayConcordance[2][1]=$arrayConcordance[2][1].$i;
                }else{
                $arrayConcordance[2][1]=$arrayConcordance[2][1].$i.",";}}
            }
            
            */
        return $arrayConcordance;}
        ?>
        
         <?php
        function tabelDisordance($arrayDisordance,$arrayV){
            global $banyakAlternatif;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){
            for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
            if($baris==$kolom){$arrayDisordance[$baris][$kolom]=" ";}
            else{
            $arrayDisordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]<$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[$baris][$kolom]=$arrayDisordance[$baris][$kolom].$i;
                }else{
                $arrayDisordance[$baris][$kolom]=$arrayDisordance[$baris][$kolom].$i.",";}}
            }}}}
            /*
            //galaxy terhadap iphone
            //di bikin for
            $arrayDisordance[0][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[0][$j]<$arrayV[1][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[0][1]=$arrayDisordance[0][1].$i;
                }else{
                $arrayDisordance[0][1]=$arrayDisordance[0][1].$i.",";}}
            }
            //galaxy terhadap BB
            $arrayDisordance[0][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[0][$j]<$arrayV[2][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[0][2]=$arrayDisordance[0][2].$i;
                }else{
                $arrayDisordance[0][2]=$arrayDisordance[0][2].$i.",";}}
            }
            //Iphone terhadap Galaxy
            $arrayDisordance[1][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]<$arrayV[0][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[1][0]=$arrayDisordance[1][0].$i;
                }else{
                $arrayDisordance[1][0]=$arrayDisordance[1][0].$i.",";}}
            }
            //Iphone terhadap BB
            $arrayDisordance[1][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]<$arrayV[2][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[1][2]=$arrayDisordance[1][2].$i;
                }else{
                $arrayDisordance[1][2]=$arrayDisordance[1][2].$i.",";}}
            }
            //BB terhadap Galaxy
            $arrayDisordance[2][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]<$arrayV[0][$j]){
                $i=$j+1;
                if($j==5){
                $arrayDisordance[2][0]=$arrayDisordance[2][0].$i;
                }else{
                $arrayDisordance[2][0]=$arrayDisordance[2][0].$i.",";}}
            }
            //BB terhadap Iphone
            $arrayDisordance[2][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]<$arrayV[1][$j]){
                $i=$j+1;
                if($j==5){
                $arrayDisordance[2][1]=$arrayDisordance[2][1].$i;
                }else{
                $arrayDisordance[2][1]=$arrayDisordance[2][1].$i.",";}}
            }
            */
            
        return $arrayDisordance;}
        ?>
        
        <?php
        function matriksConcordance($arrayMatriksConcordance,$arrayV,$arraySoal){
            global $banyakAlternatif;
            $baris=0;
            $targetBaris=3;
            $kolom=0;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){
             for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
                 if($kolom==$baris){$arrayMatriksConcordance[$baris][$kolom]=" ";}
                 else{
            $arrayMatriksConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[$baris][$kolom]+=$arraySoal[$targetBaris][$j];
            }
            }
            }}}
            /*
            
            
            
            //galaxy terhadap iphone
            $arrayMatriksConcordance[0][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[0][$j]>=$arrayV[1][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[0][1]=$arrayMatriksConcordance[0][1]+$arraySoal[3][$j];
            }
            }
            //galaxy terhadap BB
            $arrayMatriksConcordance[0][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[0][$j]>=$arrayV[2][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[0][2]=$arrayMatriksConcordance[0][2]+$arraySoal[3][$j];
            }
            }
            //Iphone terhadap Galaxy
            $arrayMatriksConcordance[1][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]>=$arrayV[0][$j]){
                $i=$j+1;
                
                $arrayMatriksConcordance[1][0]=$arrayMatriksConcordance[1][0]+$arraySoal[3][$j];
            }
            }
            //Iphone terhadap BB
            $arrayMatriksConcordance[1][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]>=$arrayV[2][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[1][2]=$arrayMatriksConcordance[1][2]+$arraySoal[3][$j];
            }
            }
            //BB terhadap Galaxy
            $arrayMatriksConcordance[2][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]>=$arrayV[0][$j]){
                $i=$j+1;
               $arrayMatriksConcordance[2][0]=$arrayMatriksConcordance[2][0]+$arraySoal[3][$j];
            }
            }
            //BB terhadap Iphone
            $arrayMatriksConcordance[2][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]>=$arrayV[1][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[2][1]=$arrayMatriksConcordance[2][1]+$arraySoal[3][$j];}
            }
            
            */
        return $arrayMatriksConcordance;}
        ?>
        
        <?php
        function matriksDisordance($arrayMatriksDisordance,$arrayV){
            global $banyakAlternatif;
            $baris=0;$kolom=1;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){ $barisTarget=0;
            for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
            if($baris==$kolom){$arrayMatriksDisordance[$baris][$kolom]="-";$barisTarget++;}
            else{
            if($baris==$barisTarget){$barisTarget++;}
            else{
            $arrayPembagi=array();$arrayDibagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[$baris][$j]-$arrayV[$barisTarget][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]<$arrayV[$barisTarget][$j]){
                $arrayDibagi[$i]=$arrayV[$baris][$j]-$arrayV[$barisTarget][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi); 
            if($dibagi==0){
                $arrayMatriksDisordance[$baris][$kolom]=="-";
            }else{
                $arrayMatriksDisordance[$baris][$kolom]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[$baris][$kolom]==0){$arrayMatriksDisordance[$baris][$kolom]="0";}
            }$barisTarget++;}
            }}}
            
            
            /*
            
           //galaxy terhadap BB
            //mencari max pembagi galaxy terhadap BB
            $arrayPembagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[0][$j]-$arrayV[2][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi=array();
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[0][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[0][$j]<$arrayV[2][$j]){
                $arrayDibagi[$i]=$arrayV[0][$j]-$arrayV[2][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi);
            if($dibagi==0){
                $arrayMatriksDisordance[0][1]=="-";
            }else{
                $arrayMatriksDisordance[0][2]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[0][2]==0){$arrayMatriksDisordance[0][2]="-";}
            }
            
            //Baris Iphone
            //Iphone terhadap Galaxy
            //mencari max pembagi Iphone terhadap Galaxy
            $arrayPembagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[1][$j]-$arrayV[0][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi=array();
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[1][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]<$arrayV[0][$j]){
                $arrayDibagi[$i]=$arrayV[1][$j]-$arrayV[0][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi);
             if($dibagi==0){
                $arrayMatriksDisordance[0][1]=="-";
            }else{
                $arrayMatriksDisordance[1][0]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[1][0]==0){$arrayMatriksDisordance[1][0]="-";}
             }
            //Iphone terhadap BB
            //mencari max pembagi Iphone terhadap BB
            $arrayPembagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[1][$j]-$arrayV[2][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi=array();
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[1][2]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[1][$j]<$arrayV[2][$j]){
                $arrayDibagi[$i]=$arrayV[1][$j]-$arrayV[2][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi); 
             if($dibagi==0){
                $arrayMatriksDisordance[0][1]=="-";
            }else{
                $arrayMatriksDisordance[1][2]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[1][2]==0){$arrayMatriksDisordance[1][2]="-";}
             }
            
            
            
            //Baris BB
            //BB terhadap Galaxy
            //mencari max pembagi BB terhadap Galaxy
            $arrayPembagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[2][$j]-$arrayV[0][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi=array();
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[2][0]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]<$arrayV[0][$j]){
                $arrayDibagi[$i]=$arrayV[2][$j]-$arrayV[0][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi);
             if($dibagi==0){
                $arrayMatriksDisordance[0][1]=="-";
            }else{
                $arrayMatriksDisordance[2][0]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[2][0]==0){$arrayMatriksDisordance[2][0]="-";}
             }
            //BB terhadap Iphone
            //mencari max pembagi BB terhadap Iphone
            $arrayPembagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[2][$j]-$arrayV[1][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi=array();
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[2][1]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[2][$j]<$arrayV[1][$j]){
                $arrayDibagi[$i]=$arrayV[2][$j]-$arrayV[1][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi); 
             if($dibagi==0){
                $arrayMatriksDisordance[0][1]=="-";
            }else{
                $arrayMatriksDisordance[2][1]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[2][1]==0){$arrayMatriksDisordance[2][1]="-";}
             }
            */
            
        return $arrayMatriksDisordance;}
        ?>
        
        <?php
        function tresholdConcordance($arrayMatriksConcordance){
            global $banyakAlternatif;
            $jawaban=0;
            for($i=0;$i<$banyakAlternatif-1;$i++){
               for($j=0;$j<$banyakAlternatif-1;$j++){
                $jawaban=$arrayMatriksConcordance[$i][$j]+$jawaban;
            } 
            }
            global $namaBarangTanpaBobot;
            $banyakKriteria=count($namaBarangTanpaBobot);
            $jawaban=$jawaban/($banyakKriteria*($banyakKriteria-1));
            return $jawaban;
        }
        ?>
        
        <?php
        function tresholdDisordance($arrayMatriksDisordance){
            global $banyakAlternatif;
            $jawaban=0;
            for($i=0;$i<$banyakAlternatif-1;$i++){
               for($j=0;$j<$banyakAlternatif-1;$j++){
                $jawaban=$arrayMatriksDisordance[$i][$j]+$jawaban;
            } 
            }
            global $namaBarangTanpaBobot;
            $banyakKriteria=count($namaBarangTanpaBobot);
            $jawaban=$jawaban/($banyakKriteria*($banyakKriteria-1));
            return $jawaban;
        }
        ?>
        
        <?php
        function matriksDominanConcordance($arrayMatriksDominanConcordance,$tresholdConcordance,$arrayMatriksConcordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    
                    if($arrayMatriksConcordance[$i][$j]>=$tresholdConcordance){
                        
                        $arrayMatriksDominanConcordance[$i][$j]="1";
                    }
                    else{
                        $arrayMatriksDominanConcordance[$i][$j]="0";
                    }
                }
            }
            return $arrayMatriksDominanConcordance;
        }
        ?>
        
        <?php
        function matriksDominanDisordance($arrayMatriksDominanDisordance,$tresholdDisordance,$arrayMatriksDisordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    
                        if($arrayMatriksDisordance[$i][$j]>=$tresholdDisordance){
                        
                        $arrayMatriksDominanDisordance[$i][$j]="1";
                    }
                        else{
                        $arrayMatriksDominanDisordance[$i][$j]="0";
                    }
                }
            }
            return $arrayMatriksDominanDisordance;
        }
        ?>
        
        <?php
        function agregatDominanceMatriks($arrayAgregatDominanceMatriks,$arrayMatriksDominanConcordance,$arrayMatriksDominanDisordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    $hasilPerkalianMatriksDominan=$arrayMatriksDominanConcordance[$i][$j]*$arrayMatriksDominanDisordance[$i][$j];
                    if($hasilPerkalianMatriksDominan==1){
                        $arrayAgregatDominanceMatriks[$i][$j]="1";
                    }else{
                        $arrayAgregatDominanceMatriks[$i][$j]="0";
                    }
                }
            }
            return $arrayAgregatDominanceMatriks;
        }
        
        ?>
        <?php
        
        function perangkingan($arrayAgregatDominanceMatriks){
            $perangkinganBaris=array();
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                $perangkinganBaris[$i]=" ";
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    $perangkinganBaris[$i]=$arrayAgregatDominanceMatriks[$i][$j]+ $perangkinganBaris[$i];
            }}
            $tertinggi=max($perangkinganBaris);
            if($tertinggi==0){return $ruangTertinggi=10;}
           
            foreach($perangkinganBaris as $key => $value){   
                if($tertinggi==$value){
                    $ruangTertinggi=$key;
                    return $ruangTertinggi;
                }
            }
        }
        ?>
    </body>
    
</html>
