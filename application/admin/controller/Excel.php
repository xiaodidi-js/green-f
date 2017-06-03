<?php 
namespace app\admin\controller;
use think\Controller;

import('PHPExcel', EXTEND_PATH.'/PHPExcel/');

class Excel extends Controller
{
    function __construct(){
        parent::__construct();
    }

	public function sincewriter($cart,$cxsince) {
        $obj = new \PHPExcel();
        $obj->getProperties()->setCreator("JAMES")
            ->setLastModifiedBy("JAMES")
            ->setTitle("zltrans")
            ->setSubject("Dorder")
            ->setDescription("Dorder List")
            ->setKeywords("Dorder")
            ->setCategory("Test result file");
        $m = 0;
        foreach ($cart as $key => $value) {
            $obj->createSheet();
            $obj->setactivesheetindex($m);
            $actSheet = $obj->getActiveSheet();
            $actSheet->setTitle($cxsince[$key]['name']);
            $obj->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $obj->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objSheet = $obj->getActiveSheet();
            //相关行高
            $n = 'a';
            for ($i = 0; $i < 18; $i++) {
                $obj->getActiveSheet()->getRowDimension($i)->setRowHeight(40);
                $objSheet->getColumnDimension($n++)->setWidth(12);
            }

            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(25);

            //标题
            $obj->getActiveSheet()->mergeCells('A1:H1');

            $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
            $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $obj->getActiveSheet()->setCellValue("A1", "绿秧田提货单签收单");

            $obj->getActiveSheet()->mergeCells('A2:D2');
            $obj->getActiveSheet()->setCellValue("A2", "提货站点：" . $cxsince[$key]['name']);

            $obj->getActiveSheet()->mergeCells('E2:H2');
            $obj->getActiveSheet()->setCellValue("E2", "出货时间：" . date("Y-m-d"));

            $obj->getActiveSheet()->mergeCells('A3:H3');
            $obj->getActiveSheet()->setCellValue("A4", "本次物品签收表");

            $obj->getActiveSheet()->setCellValue("A4", "序号");
            $obj->getActiveSheet()->setCellValue("B4", "订单号");
            $obj->getActiveSheet()->setCellValue("C4", "金额");
            $obj->getActiveSheet()->setCellValue("D4", "提货确定");

            $obj->getActiveSheet()->setCellValue("E4", "序号");
            $obj->getActiveSheet()->setCellValue("F4", "订单号");
            $obj->getActiveSheet()->setCellValue("G4", "金额");
            $obj->getActiveSheet()->setCellValue("H4", "提货确定");

            $len = 5;
            $len2 = 5;

            $count = count($value);

            foreach ($value as $key => $vo) {

                if ($key < $count / 2 + 3 ) {
                    $obj->getActiveSheet()->setCellValue("A" . $len, $key + 1);
                    $obj->getActiveSheet()->setCellValue("B" . $len, $vo['orderid']);
                    $obj->getActiveSheet()->setCellValue("C" . $len, ' ' . $vo['sum']);
                    $obj->getActiveSheet()->setCellValue("D" . $len, '');
                    $len++;
                } else {
                    $obj->getActiveSheet()->setCellValue("E" . $len2, $key + 1);
                    $obj->getActiveSheet()->setCellValue("F" . $len2, $vo['orderid']);
                    $obj->getActiveSheet()->setCellValue("G" . $len2, ' ' . $vo['sum']);
                    $obj->getActiveSheet()->setCellValue("H" . $len2, ' ');
                    $len2++;
                }
            }

            $hang = $len;

            $obj->getActiveSheet()->mergeCells('A' . $hang . ':B' . $hang);
            $obj->getActiveSheet()->setCellValue("A" . $hang, '绿秧田送货员签名送达');
            $obj->getActiveSheet()->mergeCells('C' . $hang . ':D' . $hang);
            $obj->getActiveSheet()->setCellValue("C" . $hang, '');
            $obj->getActiveSheet()->mergeCells('F' . $hang . ':H' . ($hang + 2));

            $hang++;
            $obj->getActiveSheet()->mergeCells('A' . $hang . ':C' . $hang);
            $obj->getActiveSheet()->setCellValue("A" . $hang, '本次物品袋数：');
            $obj->getActiveSheet()->setCellValue('D' . $hang, $count);
            $obj->getActiveSheet()->setCellValue('E' . $hang, '袋');
            $hang++;
            $obj->getActiveSheet()->mergeCells('A' . $hang . ':B' . $hang);
            $obj->getActiveSheet()->setCellValue("A" . $hang, '本次提货点签名签收：');
            $obj->getActiveSheet()->mergeCells('C' . $hang . ':E' . $hang);
            $obj->getActiveSheet()->getStyle('A1:H' . $hang)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $m++;
        }
        
        $name = time();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    public function excel_foreach($from, $row, $name, $actSheet){
        $num = count($name);
        $n = 0;
        $k = $from + $num;
        $c = $from - 0;
        for ($i = $c; $i < $k; $i++) {
            $actSheet->setCellValue($from++ . $row, $name[$n]);
            $n++;
        }

    }

//   采购表导出
    public function caigouexcel($data){
        $obj = new \PHPExcel();
        $obj->getProperties()->setCreator("JAMES")
            ->setLastModifiedBy("JAMES")
            ->setTitle("zltrans")
            ->setSubject("Dorder")
            ->setDescription("Dorder List")
            ->setKeywords("Dorder")
            ->setCategory("Test result file");

        $obj->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $obj->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $actSheet = $obj->getActiveSheet();

        //相关行高
        $actSheet->getRowDimension('1')->setRowHeight(40);
        $actSheet->getRowDimension('2')->setRowHeight(25);
        $actSheet->getRowDimension('3')->setRowHeight(25);
        $actSheet->getRowDimension('4')->setRowHeight(25);

        //相关列宽
        $actSheet->getColumnDimension('A')->setWidth(10);
        $actSheet->getColumnDimension('B')->setWidth(20);
        $actSheet->getColumnDimension('C')->setWidth(15);
        $actSheet->getColumnDimension('D')->setWidth(15);
        $actSheet->getColumnDimension('E')->setWidth(10);
        $actSheet->getColumnDimension('F')->setWidth(18);
        $actSheet->getColumnDimension('G')->setWidth(15);
        $actSheet->getColumnDimension('H')->setWidth(35);
        $actSheet->getColumnDimension('I')->setWidth(15);
        $actSheet->getColumnDimension('J')->setWidth(15);
        $actSheet->getColumnDimension('K')->setWidth(10);
        $actSheet->getColumnDimension('L')->setWidth(10);
        $actSheet->getColumnDimension('M')->setWidth(15);
        $actSheet->getColumnDimension('N')->setWidth(10);
        $actSheet->getColumnDimension('O')->setWidth(15);
        $actSheet->getColumnDimension('P')->setWidth(15);
        //标题
        $actSheet->mergeCells('A1:P1');
        //设置标题格式
        $actSheet->getStyle('A1')->getFont()->setSize(12);
        $actSheet->getStyle('A1')->getFont()->setBold(true);

        $actSheet->setCellValue("A1", "每日采购清单");
        $actSheet->setCellValue("A2", "截单时间");
        $actSheet->setCellValue("B2", date("Y-m-d H:i:s"));
        $actSheet->getStyle('A2:B2')->getFont()->setSize(12);
        $actSheet->getStyle('A2:B2')->getFont()->setBold(true);

        $actSheet->getStyle('A3')->getFont()->setBold(true);
        $actSheet->setCellValue("A3", "入库时间");

        $actSheet->getStyle('J3:P3')->getFont()->setSize(12);
        $actSheet->getStyle('J3:P3')->getFont()->setBold(true);
        $title1 = array('当日订单量', '套餐', '供应商订货', '供应商订货', '供应商订货','供应商订货');
        $this->excel_foreach('J', 3, $title1, $actSheet);
        $actSheet->getStyle('A4:P4')->getFont()->setSize(12);
        $actSheet->getStyle('A4:P4')->getFont()->setBold(true);
        $title2 = array('序号', '配菜组', '小分类', '采购员', '供应商', '类别', '商品编码', '编号及品名', '规格（克）','份数', '克数', '克数(不含套餐数)', '总克数', '总份数', '单位总数', '供货单位');

        $this->excel_foreach('A', 4, $title2, $actSheet);
        $len = 5;
        $key = 1;
        foreach ($data as $k => $vo) {
            $taocanWeight = $vo['amount']['taocan_weight'];
            $weight = $vo['amount']['amount'] * $vo['weight'];
            $allweight = $taocanWeight + $weight;
            $allnub = $allweight / $vo['weight'];
            if($vo['unit'] == '斤'){
                $arrWeight = $allweight / 500;
            }else{
                $arrWeight = $allweight;
            }
            $title3 = array($key,
                $vo['fenjianzu'],
                null,
                $vo['caigouyuan'],
                $vo['supplier'],
                $vo['class'],
                $vo['sn_code'],
                $vo['name'],
                $vo['weight'],
                $vo['amount']['amount'],
                $taocanWeight,
                $weight,
                $allweight,
                $allnub,
                $arrWeight,
                $vo['unit']);
            $this->excel_foreach('A', $len, $title3, $actSheet);
            $actSheet->getRowDimension($len)->setRowHeight(25);
            $len++;
            $key++;
        }
        Vendor("phpexcel.PHPExcel.IOFactory");
        $actSheet->getStyle('A2:P' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $name = '采购清单-' . time();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    static function reader($file) {

        if (self::_getExt($file) == 'xls') {
            import("Tools.Excel.PHPExcel.Reader.Excel5");
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } elseif (self::_getExt($file) == 'xlsx') {
            import("Tools.Excel.PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        } else {
            return '路径出错';
        }

        $PHPExcel     = $PHPReader->load($file);
        $currentSheet = $PHPExcel->getSheet(0);
        $allColumn    = $currentSheet->getHighestColumn();
        $allRow       = $currentSheet->getHighestRow();
        $allColumn++;
        //$allRow变量是有多少行
        for($b = 1;$b < $allRow+1; $b++){
            //$allColumn变量是有多少列
            for($i='A'; $i!=$allColumn; $i++){
                $address = $i.$b;
                if($currentSheet->getCell($address)->getValue() == NULL){
                    $arr[$b][$i] = '';
                }else{
                    $arr[$b][$i] = $currentSheet->getCell($address)->getValue();
                }
            }
        }
        return $arr;
    }

    private static function _getExt($file) {
        return pathinfo($file, PATHINFO_EXTENSION);
    }


    public function out(){
        $file_name   = "成绩单-".date("Y-m-d H:i:s",time());
        $file_suffix = "xlsx";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file_name.$file_suffix");

        //根据业务，自己进行模板赋值。
        return $this->fetch();

    }

    public function in(){
        $content = file_get_contents('./UploadFiles/excel/ceshi.xlsx');
        dump($content);exit;


    }

}