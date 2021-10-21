<?php
session_start();
    
if(!isset($_SESSION['email']) ) {
    header('location: ../../login/login.php');
    exit;
}else{
    if($_SESSION['role'] == 'Team'){
        header('location: ../../team-viewer/');
    }
}
    
include '../../../src/connection/connection.php';
error_reporting(0);
if(isset($_POST["submit"]))
{
    if($_FILES['file']['name'])
    {
        $filename = explode(".", $_FILES['file']['name']);
        if($filename[1] == 'csv')
        {

            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while($data = fgetcsv($handle))
            {
                $email                  = mysqli_real_escape_string($connect, $data[1]);  
                $pass_def               = mysqli_real_escape_string($connect, $data[2]);
                $nama_lengkap           = mysqli_real_escape_string($connect, $data[3]);
                $flip_id                = mysqli_real_escape_string($connect, $data[4]);  
                $start_kerja            = mysqli_real_escape_string($connect, $data[5]);  
                $gender                 = mysqli_real_escape_string($connect, $data[6]);  
                $tempat_lahir           = mysqli_real_escape_string($connect, $data[7]);
                $tgl_lahir              = mysqli_real_escape_string($connect, $data[8]);
                $domisi_malang          = mysqli_real_escape_string($connect, $data[9]);
                $alamat_malang          = mysqli_real_escape_string($connect, $data[10]);
                $no_hp1                 = mysqli_real_escape_string($connect, $data[11]);
                $no_hp2                 = mysqli_real_escape_string($connect, $data[12]);
                $nama_ibu               = mysqli_real_escape_string($connect, $data[13]);
                $nama_ayah              = mysqli_real_escape_string($connect, $data[14]);
                $no_hp_keluarga         = mysqli_real_escape_string($connect, $data[15]);
                $status                 = mysqli_real_escape_string($connect, $data[16]);
                $agama                  = mysqli_real_escape_string($connect, $data[17]);
                $pendidikan             = mysqli_real_escape_string($connect, $data[18]);
                $institusi              = mysqli_real_escape_string($connect, $data[19]);
                $jurusan                = mysqli_real_escape_string($connect, $data[20]);
                $riwayat_penyakit       = mysqli_real_escape_string($connect, $data[21]);
                $pass_md = md5($pass_def);

                if($email !== 'Email' && $email !== ''){
                    $sql_check_biodata = mysqli_query($connect, "SELECT * FROM tb_biodata WHERE email='$email'");
                    if(mysqli_num_rows($sql_check_biodata) < 1) {
                    $query_biodata = "INSERT INTO tb_biodata (id_nama , email, password, nama, flip_id, start_kerja, gender, tempat_lahir, tanggal_lahir, domisili_malang, alamat_lain, telpon, telpon_2, ibu, ayah, telpon_lain, status, agama, pendidikan, institusi, jurusan, riwayat_penyakit, divisi, role) 
                    values 
                    ( NULL, '$email', '$pass_md', '$nama_lengkap', '$flip_id', '$start_kerja', '$gender', '$tempat_lahir','$tgl_lahir','$domisi_malang','$alamat_malang','$no_hp1','$no_hp2','$nama_ibu','$nama_ayah','$no_hp_keluarga','$status','$agama','$pendidikan','$institusi','$jurusan','$riwayat_penyakit', '', '')";
                    mysqli_query($connect, $query_biodata);
                    }else{}
                }


                if($email !== 'Email' && $email !== ''){
                    $sql_check_biodata = mysqli_query($connect, "SELECT * FROM account WHERE email='$email'");
                    if(mysqli_num_rows($sql_check_biodata) < 1) {
                        $check_id  = mysqli_query($connect, "SELECT * FROM tb_biodata WHERE email='$email'");
                        while($row = mysqli_fetch_array($check_id)){
                            $param_id = $row['id_nama'];
                            $query_account = "INSERT INTO tb_account (id_account, id_nama , email, pass, role) 
                            values 
                            ( NULL, '$param_id', '$email', '$pass_md', 'User')";
                            mysqli_query($connect, $query_account);
                        }
                    }
                }

                mysqli_query($connect, "DELETE FROM `tb_biodata` WHERE nama=''");
                mysqli_query($connect, "DELETE FROM `tb_account` WHERE email=''");
                

                // $date_startkerja     = str_replace("/", "-", $start_kerja);
                // $date_startkerja1    = date_create("$date_startkerja");
                // echo date_format($date_startkerja1,"M-Y");

                // $sub_sentence_date      = substr($date, 0, 10);

                // $sentence               = $date;
                // $sub_sentence           = substr($sentence, 5, 2);

                // $substance_year         = substr($date, 0, 4);

                // $sentence_day           = $date;
                // $sub_sentence_day       = substr($sentence_day, 8, 2);

                // if($status !== 'Author Fee'){
                //     $query = "INSERT INTO tb_catalog (catalog_id , item_id, market_id, upload_on, category, sub_category, color, slug, name) 
                //     values 
                //     ( NULL, $item_id, '$market', '$sub_sentence_date', '', '', '', '','$name')";
                //     $insert = mysqli_query($connect, $query);
                // }

                // mysqli_query($connect, "UPDATE tb_catalog SET slug = 'PowerPoint' WHERE name LIKE '%powerpoint%'");
                // mysqli_query($connect, "UPDATE tb_catalog SET slug = 'Keynote' WHERE name LIKE '%keynote%'");
                // mysqli_query($connect, "UPDATE tb_catalog SET slug = 'Potrait' WHERE name LIKE '%potrait%'");
                // mysqli_query($connect, "UPDATE tb_catalog SET slug = 'Google Slide' WHERE name LIKE '%google slide%'");
                // mysqli_query($connect, "UPDATE tb_catalog SET slug = 'Etc' WHERE slug=''");

                // if($status == 'Sale') {
                //     $sql_check = mysqli_query($connect, "SELECT * FROM tb_sales WHERE market_id=1 && extra='$extra'");
                //     if(mysqli_num_rows($sql_check) < 1) {
                //         $query = "INSERT INTO tb_sales (sales_id, market_id, item_id, order_id, year, month, day, date, status, earnings, country, extra) 
                //             values 
                //             ( NULL, $market, '$item_id', '$order_id', '$substance_year', '$sub_sentence', '$sub_sentence_day','$sub_sentence_date','$status','$earnings','$other_party_country', '$extra')";
                //         $insert = mysqli_query($connect, $query);
                //             if(!$insert){
                //                 echo "Error . " . mysqli_error($connect) . "</br>";
                //             }
                //     }
                // }

                // if($status == 'Author Fee Reversal'){
                //     $reversal = strstr("$name","IVI");
                //     mysqli_query($connect, "DELETE FROM `tb_sales` WHERE market_id=1 && extra='$reversal' && item_id='$item_id'");
                // }
                
            }
        }
    }
}

header("location: ../index.php?upload=success");