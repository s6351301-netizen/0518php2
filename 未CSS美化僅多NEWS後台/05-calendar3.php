<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: linear-gradient(135deg, #fff5f5 0%, #f0f4ff 50%, #f5f9ff 100%);
            height: 100vh;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            background: white;
            border-radius: 30px;
            padding: 25px 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            max-width: 1400px;
        }

        /* 普普風格邊框裝飾 */
        .container::before {
            content: "";
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 3px dashed #ffb6c1;
            border-radius: 25px;
            pointer-events: none;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 15px;
        }

        /* 標題區 */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .main-title {
            font-size: 32px;
            font-weight: 900;
            color: #ff1493;
            text-shadow: 2px 2px 0 #00bfff, 4px 4px 0 #ffff00;
            letter-spacing: 1px;
            transform: rotate(-2deg);
            margin: 0;
            white-space: nowrap;
        }

        .today-info {
            background: linear-gradient(135deg, #ffb6c1 0%, #87ceeb 100%);
            padding: 8px 18px;
            border-radius: 15px;
            color: white;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
            white-space: nowrap;
        }

        .today-label {
            font-size: 11px;
            opacity: 0.85;
        }

        /* 月份和導航 */
        .month-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .month-title {
            font-size: 28px;
            font-weight: 900;
            color: #00bfff;
            text-shadow: 1px 1px 0 #ffff00;
            margin: 0;
            white-space: nowrap;
        }

        .navigation {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-btn {
            padding: 8px 16px;
            border: 2px solid;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-family: inherit;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .prev-btn {
            background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
            color: white;
            border-color: #ff1493;
            box-shadow: 3px 3px 0 rgba(255, 20, 147, 0.3);
        }

        .prev-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0 rgba(255, 20, 147, 0.3);
        }

        .next-btn {
            background: linear-gradient(135deg, #00bfff 0%, #1e90ff 100%);
            color: white;
            border-color: #00bfff;
            box-shadow: 3px 3px 0 rgba(0, 191, 255, 0.3);
        }

        .next-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0 rgba(0, 191, 255, 0.3);
        }

        /* 日曆表格 */
        table {
            width: 100%;
            border-collapse: collapse;
            flex: 1;
            margin-bottom: 10px;
            table-layout: fixed;
        }

        /* 週末標題 */
        thead td {
            background: linear-gradient(135deg, #ffff00 0%, #ffa500 100%);
            color: #333;
            font-weight: 900;
            font-size: 14px;
            padding: 10px 4px;
            text-align: center;
            border-radius: 8px;
            text-shadow: 1px 1px 0 white;
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
            height: 40px;
            vertical-align: middle;
        }

        /* 日期單元 */
        tbody {
            display: table-row-group;
        }

        tbody tr {
            height: auto;
        }

        tbody td {
            padding: 12px 4px;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid #f0f0f0;
            background: #fafafa;
            color: #333;
            transition: all 0.2s ease;
            position: relative;
            vertical-align: middle;
            min-height: 50px;
            height: 50px;
        }

        tbody td:hover {
            background: #e8f4f8;
            transform: scale(1.03);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1) inset;
        }

        /* 不是本月的日期 */
        tbody td:empty,
        tbody td:has(:empty) {
            background: #f5f5f5;
            color: #ddd;
        }

        tbody tr:nth-child(odd) td {
            background: linear-gradient(135deg, #fff0f5 0%, #f0f8ff 100%);
        }

        /* 週末高亮 */
        tbody tr td:first-child,
        tbody tr td:last-child {
            background: linear-gradient(135deg, #ffe4e1 0%, #e0ffff 100%);
            font-weight: 900;
            color: #ff1493;
        }

        tbody tr:nth-child(odd) td:first-child,
        tbody tr:nth-child(odd) td:last-child {
            background: linear-gradient(135deg, #ffc0cb 0%, #b0e0e6 100%);
        }

        /* 當天日期特殊樣式 */
        tbody td.today {
            background: linear-gradient(135deg, #ff1493 0%, #00bfff 100%) !important;
            color: white;
            border-radius: 10px;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2), inset 0 0 0 1px #333;
            font-size: 16px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        /* 普普風格裝飾點 */
        .pop-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-1 { background: #ff1493; }
        .dot-2 { background: #ffff00; }
        .dot-3 { background: #00bfff; }
        .dot-4 { background: #ffa500; }
        .dot-5 { background: #00ff00; }

        /* 響應式設計 */
        @media (max-width: 900px) {
            .container {
                padding: 20px 20px;
            }

            .main-title {
                font-size: 26px;
                text-shadow: 1px 1px 0 #00bfff, 2px 2px 0 #ffff00;
            }

            .month-title {
                font-size: 22px;
            }

            .today-info {
                padding: 6px 12px;
                font-size: 12px;
            }

            thead td {
                font-size: 12px;
                padding: 8px 2px;
            }

            tbody td {
                padding: 10px 2px;
                font-size: 12px;
            }

            .nav-btn {
                padding: 6px 12px;
                font-size: 11px;
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px 12px;
            }

            .header {
                flex-direction: column;
                gap: 10px;
            }

            .main-title {
                font-size: 22px;
            }

            .month-title {
                font-size: 18px;
            }

            .today-info {
                padding: 5px 10px;
                font-size: 11px;
            }

            thead td {
                font-size: 11px;
                padding: 6px 1px;
            }

            tbody td {
                padding: 8px 1px;
                font-size: 11px;
            }

            .nav-btn {
                padding: 5px 10px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <?php
            $today=date("Y-m-d");
            $todayDay=date("d",strtotime($today));
            if(isset($_GET['month'])){
                $month=$_GET['month'];
            }else{
                $month=date("Y-m");
            }
            $FirstDay=$month."-01";
            $m=date("m",strtotime($FirstDay));
            $FirstDayWeek=date("w",strtotime($FirstDay));
            $MonthDays=date("t",strtotime($FirstDay));
            $LastDay=$month."-".$MonthDays;
            $LastDayWeek=date('w',strtotime($LastDay));
            $TotalDays=$MonthDays+$FirstDayWeek+(6-$LastDayWeek);
            $TotalWeeks=$TotalDays/7;
            $currentMonthStr=date("Y-m",strtotime($FirstDay));
            ?>

            <!-- 標題區 -->
            <div class="header">
                <div class="main-title">📅 月曆</div>
                <div class="today-info">
                    <span class="today-label">📍 今天是</span>
                    <?= $today; ?>
                </div>
            </div>

            <!-- 月份導航 -->
            <div class="month-section">
                <div class="month-title"><?= date("Y 年 m 月", strtotime($FirstDay)); ?></div>
                
                <div class="navigation">
                    <?php 
                        if($m-1>0){
                            $prevMonth=date("Y-",strtotime($FirstDay)).($m-1);
                        }else{
                            $prevMonth=(date("Y",strtotime($FirstDay))-1)."-12";
                        }
                    ?>
                    <a href="05-calendar3.php?month=<?= $prevMonth ?>" class="nav-btn prev-btn">← 上月</a>

                    <?php 
                        if($m+1<=12){
                            $nextMonth=date("Y-",strtotime($FirstDay)).($m+1);
                        }else{
                            $nextMonth=(date("Y",strtotime($FirstDay))+1)."-01";
                        }
                    ?>
                    <a href="05-calendar3.php?month=<?= $nextMonth ?>" class="nav-btn next-btn">下月 →</a>
                </div>
            </div>

            <!-- 日曆表格 -->
            <table>
                <thead>
                    <tr>
                        <td>日</td>
                        <td>一</td>
                        <td>二</td>
                        <td>三</td>
                        <td>四</td>
                        <td>五</td>
                        <td>六</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    for($i=0;$i<$TotalWeeks;$i++){
                        echo "<tr>";
                        for($j=0;$j<7;$j++){
                            $DayNumber=($i*7+$j)-($FirstDayWeek-1);
                            $isToday = ($currentMonthStr === $today && $DayNumber == $todayDay) ? 'today' : '';
                            echo "<td class='{$isToday}'>";
                            if($DayNumber>0 && $DayNumber<=$MonthDays){
                                echo $DayNumber;
                            }
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- 普普風格裝飾 -->
            <div class="pop-dots">
                <span class="dot dot-1"></span>
                <span class="dot dot-2"></span>
                <span class="dot dot-3"></span>
                <span class="dot dot-4"></span>
                <span class="dot dot-5"></span>
            </div>
        </div>
    </div>


</body>
</html>