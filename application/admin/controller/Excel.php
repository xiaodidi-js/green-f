<?php 
namespace app\admin\controller;
use think\Controller;
class Excel extends Controller
{
    function __construct(){
        parent::__construct();
    }

    // 自提点清单
	public function sincewriter($cart,$cxsince,$time) {
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
            $obj->getActiveSheet()->setCellValue("E2", "出货时间：" . $time);

            $obj->getActiveSheet()->mergeCells('A3:H3');
            $obj->getActiveSheet()->setCellValue("A3", $cxsince[$key]['address']);

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

    // 表格循环
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

    // 采购表导出
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
        $actSheet->getColumnDimension('C')->setWidth(20);
        $actSheet->getColumnDimension('D')->setWidth(15);
        $actSheet->getColumnDimension('E')->setWidth(15);
        $actSheet->getColumnDimension('F')->setWidth(18);
        $actSheet->getColumnDimension('G')->setWidth(15);
        $actSheet->getColumnDimension('H')->setWidth(35);
        $actSheet->getColumnDimension('I')->setWidth(35);
        $actSheet->getColumnDimension('J')->setWidth(15);
        $actSheet->getColumnDimension('K')->setWidth(10);
        $actSheet->getColumnDimension('L')->setWidth(10);
        $actSheet->getColumnDimension('M')->setWidth(15);
        $actSheet->getColumnDimension('N')->setWidth(10);
        $actSheet->getColumnDimension('O')->setWidth(15);
        $actSheet->getColumnDimension('P')->setWidth(15);
        $actSheet->getColumnDimension('Q')->setWidth(15);
        $actSheet->getColumnDimension('R')->setWidth(15);
        $actSheet->getColumnDimension('S')->setWidth(20);
        $actSheet->getColumnDimension('T')->setWidth(20);
        //标题
        $actSheet->mergeCells('A1:T1');
        //设置标题格式
        $actSheet->getStyle('A1')->getFont()->setSize(12);
        $actSheet->getStyle('A1')->getFont()->setBold(true);

        $actSheet->setCellValue("A1", "每日采购清单");
        $actSheet->setCellValue("B2", "截单时间");
        $actSheet->mergeCells('C2:D2');
        $actSheet->setCellValue("C2", date("Y-m-d H:i:s"));
        $actSheet->getStyle('A2:C2')->getFont()->setSize(12);
        $actSheet->getStyle('A2:C2')->getFont()->setBold(true);

        $actSheet->getStyle('B3')->getFont()->setBold(true);
        $actSheet->setCellValue("B3", "入库时间");
        $actSheet->setCellValue("D3", "签收:");

        $actSheet->getStyle('J3:T3')->getFont()->setSize(12);
        $actSheet->getStyle('J3:T3')->getFont()->setBold(true);
        $title1 = array();
        $this->excel_foreach('J', 3, $title1, $actSheet);
        $actSheet->getStyle('A4:T4')->getFont()->setSize(12);
        $actSheet->getStyle('A4:T4')->getFont()->setBold(true);
        $title2 = array('序号', '供应商', '供应商联系方式', '采购员', '联系方式', '配菜组', '类别', '商品编号', '名称','规格', '单位', '订单数', '非套餐(g)', '套餐(g)', '总重量(g)', '总(份数)','单位总数','单位','分享购买份数','二维码商品份数');

        $this->excel_foreach('A', 4, $title2, $actSheet);
        $len = 5;
        $key = 1;
        foreach ($data as $k => &$vo) {
            if(empty($vo['amount']['share'])){
                $share = 0;
            }else{
                $share = $vo['amount']['share'];
            }
            if(empty($vo['amount']['qrcode'])){
                $qrcode = 0;
            }else{
                $qrcode = $vo['amount']['qrcode'];
            }
            $taocanWeight = $vo['amount']['taocan_weight'];
            $weight = $vo['amount']['amount'] * $vo['weight'];
            $allweight = $taocanWeight + $weight;
            if(!empty($vo['weight'])){
                $allnub = $allweight / $vo['weight'];
            }else{
                $allnub = '商品没有重量';
            }
            if($vo['unit'] == '斤'){
                $arrWeight = $allweight / 500;
            }else{
                $arrWeight = $allweight;
            }
            $title3 = array(
                $key,
                $vo['supplier'],
                $vo['suppliertel'],
                $vo['caigouyuan'],
                $vo['caigouyuantel'],
                $vo['fenjianzu'],
                $vo['class'],
                $vo['sn_code'],
                $vo['name'],
                $vo['weight'],
                $vo['unit'],
                $vo['amount']['amount'],
                $allweight,
                $taocanWeight,
                $weight,
                $allnub,
                $arrWeight,
                $vo['unit'],
                $share,
                $qrcode);
            $this->excel_foreach('A', $len, $title3, $actSheet);
            $actSheet->getRowDimension($len)->setRowHeight(25);
            $len++;
            $key++;
        }
        Vendor("phpexcel.PHPExcel.IOFactory");
        $actSheet->getStyle('A2:T' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
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

    // 公司销售表
    public function xiaoshou($orderdata,$time){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $obj->getActiveSheet()->getRowDimension('3')->setRowHeight(23);
        $obj->getActiveSheet()->getRowDimension('4')->setRowHeight(24);
        $obj->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $obj->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $obj->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $obj->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $obj->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $obj->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $obj->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:K1');
        $obj->getActiveSheet()->mergeCells('A2:B2');
        $obj->getActiveSheet()->mergeCells('C2:E2');

        $obj->getActiveSheet()->mergeCells('G2:I2');
        $obj->getActiveSheet()->mergeCells('G3:I3');
        $obj->getActiveSheet()->mergeCells('G4:I4');
        $obj->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $obj->getActiveSheet()->getStyle('G2:K4')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        $obj->getActiveSheet()->mergeCells('J2:K2');
        $obj->getActiveSheet()->mergeCells('J3:K3');
        $obj->getActiveSheet()->mergeCells('J4:K4');

        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $obj->getActiveSheet()->setCellValue("A1", "销售明细表");
        $obj->getActiveSheet()->setCellValue("A2", "报表日期");
/*        $obj->getActiveSheet()->setCellValue("A3", "日关注新客户数：人");
        $obj->getActiveSheet()->setCellValue("A4", "日注册新客户数：人");*/
        $obj->getActiveSheet()->setCellValue("C2", $time['stime'].'-'.$time['etime']);
/*        $obj->getActiveSheet()->setCellValue("C3", $guanzhu);
        $obj->getActiveSheet()->setCellValue("C4", $guanzhu);*/
        $obj->getActiveSheet()->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        $obj->getActiveSheet()->setCellValue("G2", "货总订单数：张");
        $obj->getActiveSheet()->setCellValue("J2", $orderdata['ordernum']);
        $obj->getActiveSheet()->setCellValue("G3", "货总金额：元");
        $obj->getActiveSheet()->setCellValue("G4", "货订单均价：元");

        $obj->getActiveSheet()->mergeCells('A6:A7');
        $obj->getActiveSheet()->mergeCells('B6:B7');
        $obj->getActiveSheet()->mergeCells('C6:C7');
        $obj->getActiveSheet()->mergeCells('D6:D7');
        $obj->getActiveSheet()->mergeCells('E6:E7');
        $obj->getActiveSheet()->mergeCells('F6:I6');
        $obj->getActiveSheet()->mergeCells('J6:K6');
        $title1 = array('序号', '类别', '供应商', '商品编码', '商品名');
        $this->excel_foreach('A', 6, $title1, $obj->getActiveSheet());
        $obj->getActiveSheet()->setCellValue("F6", "销量");
        $obj->getActiveSheet()->setCellValue("J6", "营业额");
        $title2 = array('份数','单位', '规格', '总重量', '单价', '销售总金额');
        $this->excel_foreach('F', 7, $title2, $obj->getActiveSheet());

        $len = 8;
        $key = 1;
        $sum = 0;
        foreach ($orderdata['data'] as $vo) {
                $title3 = array($key, $vo['title'], 
                $vo['suppliername'], 
                $vo['sn_code'], 
                $vo['name'], 
                $vo['amount'],
                $vo['unit'],
                $vo['weight'], 
                $vo['weight'] * $vo['amount'], 
                $vo['price'], 
                $vo['listprice']);
            $this->excel_foreach('A', $len, $title3, $obj->getActiveSheet());
            $obj->getActiveSheet()->getRowDimension($len)->setRowHeight(25);
            // $sum += $vo['sum'];
            $len++;
            $key++;
        }
        $obj->getActiveSheet()->setCellValue("J3", $orderdata['money']);
        $obj->getActiveSheet()->setCellValue("J4", $orderdata['zonghe']);
        $obj->getActiveSheet()->getStyle('A6:K' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $name = $time['stime'].'至'.$time['etime'].'公司销售表';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 站点销售表
    public function sincexiaoshou($orderdata,$time){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:G1');
        $obj->getActiveSheet()->setCellValue("A1", $time['stime'].'至'.$time['etime'].'提货点销售日报表/月报表');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '自提点', '状态','注册客户数', '出货订单数', '出货总金额', '均客单价');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($orderdata as $key => $value) {
            $title2 = array(
                $key+1, 
                $value['name'],
                $value['status'],
                $value['sid'],
                $value['ordernum'],
                $value['money'],
                round($value['moneyhe'],2)
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:G' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = $time['stime'].'至'.$time['etime'].'站点销售表';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 评价统计
    public function comment($data){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:E1');
        $obj->getActiveSheet()->setCellValue("A1",'商品评价统计');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '商品名称', '好评','中评', '差评');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            $title2 = array(
                $key+1, 
                $value['name'],
                $value['cha'],
                $value['zhong'],
                $value['hao'],
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:E' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = date('Y-m-d H:i:s').'商品评价统计';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 商品推荐
    public function tuijian($data,$name){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:G1');
        $obj->getActiveSheet()->setCellValue("A1",$name.'商品推荐');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '商品名称', '价格','商品编码', '排序', '点击量', '销量');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            $title2 = array(
                $key+1, 
                $value['name'],
                $value['price'],
                $value['sn_code'],
                $value['sort'],
                $value['rate'],
                $value['pay'],
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:G' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = date('Y-m-d H:i:s').$name.'商品推荐';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 商品导出
    public function product($data){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:H1');
        $obj->getActiveSheet()->setCellValue("A1",'商品表');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '商品名称', '分类','价格', '库存', '销量', '排序');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            $title2 = array(
                $key+1, 
                $value['sn_code'],
                $value['name'],
                $value['title'],
                $value['price'],
                $value['store'],
                $value['sale'],
                $value['sort'],
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(45);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:H' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = date('Y-m-d H:i:s').'商品表';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 首单用户Excel
    public function shoudan($data,$time){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:G1');
        $obj->getActiveSheet()->setCellValue("A1",$time['stime'].'至'.$time['etime'].'首单用户');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '订单编号', '联系电话','下单时间', '总金额', '实际支付金额', '发货时间');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            $title2 = array(
                $key+1, 
                $value['orderid'],
                $value['tel'],
                date('Y-m-d H:i:s',$value['createtime']),
                $value['sum'],
                $value['money'],
                date('Y-m-d H:i:s',$value['stime']),
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:G' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = $time['stime'].'至'.$time['etime'].'首单用户';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 指定日数未消费用户Excel
    public function weixiaofei($data,$time){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:F1');
        $obj->getActiveSheet()->setCellValue("A1",$time.'未消费用户');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '用户名','联系电话','最后消费记录', '总金额', '实际支付金额');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            if($value['endtime']){
                $endtime = date('Y-m-d H:i:s',$value['endtime']);
            }else{
                $endtime = '此用户没在商城消费记录';
            }
            $title2 = array(
                $key+1, 
                $value['uname'],
                $value['utel'],
                $endtime,
                $value['sum'],
                $value['money'],
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:F' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = $time.'未消费用户';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }

    // 会员表导出
    public function huiyuan($data){
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
        //相关行高
        $obj->getActiveSheet()->getRowDimension('2')->setRowHeight(40);

        //标题
        $obj->getActiveSheet()->mergeCells('A1:H1');
        $obj->getActiveSheet()->setCellValue("A1",'会员名单');
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $obj->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $title1 = array('序号', '账号名称', '手机号码','性别', '生日', '累计消费金额', '商城积分','注册时间');
        $this->excel_foreach('A', 2, $title1, $obj->getActiveSheet());
        $len = 3;
        foreach ($data as $key => $value) {
            if($value['sex'] == 0){
                $sex = '男';
            }else{
                $sex = '女';
            }
            $title2 = array(
                $key+1, 
                $value['uname'],
                $value['utel'],
                $sex,
                $value['birthday'],
                $value['money'],
                $value['score'],
                date('Y-m-d H:i:s',$value['createtime']),
            );
            $this->excel_foreach('A', $len, $title2, $obj->getActiveSheet());
            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $len++;
        }
        $obj->getActiveSheet()->getStyle('A1:H' . $len)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        Vendor("phpexcel.PHPExcel.IOFactory");
        $name = '会员名单';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($obj, 'Excel5');
        $objWriter->save('php://output');
    }
}