<?php
class Home extends ControllerBase{
    public function Index(){
        echo 'Trang chu';
    }

    public function Show($a, $b){       
        $teo = $this->model("SinhVienModel");
        $tong = $teo->Tong($a, $b);

        $this->view("aodep", [
            "Page"=>"news",
            "Number"=>$tong,
            "Mau"=>"red",
            "SoThich"=>["A", "B", "C"],
            "SV" => $teo->SinhVien()
        ]);
    }
}
?>