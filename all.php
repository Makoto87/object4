<?php

// ここから書いてください
class Point{
    public $x;
    public $y;

    function __construct($x, $y){
        $this->x = $x;
        $this->y = $y;
    }
}

class Line{
    public Point $startPoint;
    public Point $endPoint;

    function __construct(Point $startPoint, Point $endPoint){
        $this->startPoint = $startPoint;
        $this->endPoint = $endPoint;
    }
}

class QuadrilateralShape {
    public Line $lineA;
    public Line $lineB;
    public Line $lineC;
    public Line $lineD;

    // 各辺の長さ
    public $lengthA;
    public $lengthB;
    public $lengthC;
    public $lengthD;
    public $lengthAC;

    function __construct(Line $lineA, Line $lineB, Line $lineC, Line $lineD) {
        $this->lineA = $lineA;
        $this->lineB = $lineB;
        $this->lineC = $lineC;
        $this->lineD = $lineD;
    }

    // 形が何かを返す
    // function getShapeType() {
        
    // }

    // 四辺の長さを返す
    function getPerimeter() {
        $length = 0;
        // lineAの辺の長さを足す。メンバ変数に格納する。
        $this->lengthA = sqrt(($this->lineA->endPoint->x - $this->lineA->startPoint->x) ** 2 + ($this->lineA->endPoint->y - $this->lineA->startPoint->y) ** 2);
        $length += $this->lengthA;
        
        // lineB
        $this->lengthB = sqrt(($this->lineB->endPoint->x - $this->lineB->startPoint->x) ** 2 + ($this->lineB->endPoint->y - $this->lineB->startPoint->y) ** 2);
        $length += $this->lengthB;

        // lineC
        $this->lengthC = sqrt(($this->lineC->endPoint->x - $this->lineC->startPoint->x) ** 2 + ($this->lineC->endPoint->y - $this->lineC->startPoint->y) ** 2);
        $length += $this->lengthC;

        // lineD
        $this->lengthD = sqrt(($this->lineD->endPoint->x - $this->lineD->startPoint->x) ** 2 + ($this->lineD->endPoint->y - $this->lineD->startPoint->y) ** 2);
        $length += $this->lengthD;

        return $length;
    }

    // 四角形の面積を求める。ヘロンの公式を使う
    // 長さを求めた後に処理をしなければ、各辺の長さが格納していないので論理エラーが起こる
    function getArea() {
        // 開始の点と3つめの点を結ぶ線
        $acLineLength = sqrt(($this->lineA->startPoint->x - $this->lineB->endPoint->x) ** 2 + ($this->lineA->startPoint->y - $this->lineB->endPoint->y) ** 2);
        $this->$lengthAC = $acLineLength;
        // 開始・2つめ・3つめの点を結んだ面積を求める
        $sABC = ($this->lengthA + $this->lengthB + $acLineLength) / 2;
        $halfAreaABC = sqrt($sABC * ($sABC - $this->lengthA) * ($sABC - $this->lengthB) * ($sABC - $acLineLength));
        // 3つめ・4つめ・終わりの点を結んだ面積を求める
        $sCDA = ($this->lengthC + $this->lengthD + $acLineLength) / 2;
        $halfAreaCDA = sqrt($sCDA * ($sCDA - $this->lengthC) * ($sCDA - $this->lengthD) * ($sCDA - $acLineLength));

        return $halfAreaABC + $halfAreaCDA;
    }

    // 角度を返す。BAD, ABC, ADC, BCDのどれかが入力される
    function getAngle($angleString) {
        // 2つめと4つめの点を結んだ線
        $bdLineLength = sqrt(($this->lineB->startPoint->x - $this->lineC->endPoint->x) ** 2 + ($this->lineB->startPoint->y - $this->linCB->endPoint->y) ** 2);
        // 角度を求める。コサイン->アークコサイン->角度
        if ($angleString == "BAD") {
            $cosine = (($this->lengthA) ** 2 + ($this->lengthD) ** 2 - $bdLineLength ** 2) / (2 * $this->lengthA * $this->lengthD);
            return rad2deg(acos($cosine));
        } else if ($angleString == "ABC") {
            $cosine = (($this->lengthA) ** 2 + ($this->lengthB) ** 2 - $this->$lengthAC ** 2) / (2 * $this->lengthA * $this->lengthB);
            return rad2deg(acos($cosine));
        } else if($angleString == "ADC") {
            $cosine = (($this->lengthD) ** 2 + ($this->lengthC) ** 2 - $this->$lengthAC ** 2) / (2 * $this->lengthD * $this->lengthC);
            return rad2deg(acos($cosine));
        } 
        else {
            $cosine = (($this->lengthB) ** 2 + ($this->lengthC) ** 2 - $bdLineLength ** 2) / (2 * $this->lengthB * $this->lengthC);
            return rad2deg(acos($cosine));
        }
        
    }
}

// 線を用意する
$line1 = new Line(new Point(0,0), new Point(2,6));
$line2 = new Line(new Point(2,6), new Point(0,8));
$line3 = new Line(new Point(0,8), new Point(-2,6));
$line4 = new Line(new Point(-2,6), new Point(0,0));

// 四角形を作る
$quadrilateralShape = new QuadrilateralShape($line1,$line2,$line3,$line4);

// 四辺の長さを出力する
echo $quadrilateralShape->getPerimeter() . PHP_EOL;

// 面積を出力する
echo $quadrilateralShape->getArea() . PHP_EOL;

// 角度を出力する
echo $quadrilateralShape->getAngle("BAD").  PHP_EOL;
echo $quadrilateralShape->getAngle("ABC").  PHP_EOL;
echo $quadrilateralShape->getAngle("ADC").  PHP_EOL;
echo $quadrilateralShape->getAngle("BCD").  PHP_EOL;