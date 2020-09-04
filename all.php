<?php
// square(正方形)、rectangle(長方形)、kite(凧)、rhombus(ひし形)、parallelogram(平行四辺形)、trapezoid(台形)

// 4点A,B,C,Dを受け取って、図形の名前を返す、getShapeTypeという関数を作成してください。
function getShapeType($pointA,$pointB,$pointC,$pointD) {
    $points = [$pointA,$pointB,$pointC,$pointD];

    // 四角形にならない条件 同じ座標の点がある
    for ($i = 0; $i < count($points) - 1; $i++) {
        if (array_search($points[$i], array_slice($points,$i+1)) !== false) {
            return "not rectangle";
        }
    }

    // 四辺の長さを求める
    $lineAB = sqrt(($pointA[0] - $pointB[0]) ** 2 + ($pointA[1] - $pointB[1]) ** 2);
    $lineBC = sqrt(($pointB[0] - $pointC[0]) ** 2 + ($pointB[1] - $pointC[1]) ** 2);
    $lineCD = sqrt(($pointC[0] - $pointD[0]) ** 2 + ($pointC[1] - $pointD[1]) ** 2);
    $lineDA = sqrt(($pointD[0] - $pointA[0]) ** 2 + ($pointD[1] - $pointA[1]) ** 2);

    // ４つの角度を求める
    $angleA = angleCalc($pointB[0], $pointB[1], $pointA[0], $pointA[1], $pointD[0], $pointD[1]);
    $angleB = angleCalc($pointA[0], $pointA[1], $pointB[0], $pointB[1], $pointC[0], $pointC[1]);
    $angleC = angleCalc($pointB[0], $pointB[1], $pointC[0], $pointC[1], $pointD[0], $pointD[1]);
    $angleD = angleCalc($pointA[0], $pointA[1], $pointD[0], $pointD[1], $pointC[0], $pointC[1]);

    // 四角形がどの形か求める
    // 全ての辺が同じ長さの場合
    if ($lineAB == $lineBC && $lineBC == $lineCD && $lineCD == $lineDA && $lineDA == $lineAB) {
        // 正方形
        if ($angleA == 90) {
            return "square(正方形)";
        // ひし形
        } else {
            return "rhombus(ひし形)";
        }
    }
    // 向かい合ってる辺が同じ長さの場合
    if ($lineAB == $lineCD && $lineBC == $lineDA) {
        // 長方形
        if ($angleA == 90) {
            return "rectangle(長方形)";
        // 平行四辺形
        } else {
            return "parallelogram(平行四辺形)";
        }
    }
    // 台形
    if ($angleA + $angleB == 180 || $angleB + $angleC == 180 || $angleC + $angleD == 180 || $angleA + $angleD == 180) {
        return "trapezoid(台形)";
    }
    // 凧
    if (($lineAB == $lineBC && $lineCD == $lineDA) || ($lineAB == $lineDA && $lineBC == $lineCD)) { return "kite(凧)"; }
    // その他
    return "その他";
    
    // return $angleA;
}

// 角度を求める関数
function angleCalc($a1,$a2,$b1,$b2,$c1,$c2){
        $a1 -= $b1; $a2 -= $b2;
        $c1 -= $b1; $c2 -= $b2;
        $cosine = ($a1*$c1 + $a2*$c2) / ((($a1**2+$a2**2)**0.5) * (($c1**2+$c2**2)**0.5));
        return round((rad2deg(acos($cosine))),1);
}

// 正方形
echo getShapeType([0,2],[2,2],[2,4],[0,4]) . PHP_EOL;
// ひし形
echo getShapeType([0,0],[5,0],[8,4],[3,4]) . PHP_EOL;
// 長方形
echo getShapeType([0,0],[5,0],[5,8],[0,8]) . PHP_EOL;
// 平行四辺形
echo getShapeType([0,0],[5,0],[8,8],[3,8]) . PHP_EOL;
// 台形
echo getShapeType([-2,0],[5,0],[8,8],[-1,8]) . PHP_EOL;
// 凧
echo getShapeType([0,0],[5,3],[0,8],[-5,3]) . PHP_EOL;
// その他
echo getShapeType([0,1],[2,3],[3,4],[2,1]) . PHP_EOL;

