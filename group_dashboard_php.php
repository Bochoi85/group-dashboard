<?php
/*
 * Group Dashboard - PHP Version
 * A comprehensive dashboard for managing group tasks and mall assignments
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            gap: 20px;
        }

        .dashboard-title {
            color: #333;
            margin: 0;
            flex: 1;
            text-align: center;
        }

        .search-container {
            display: flex;
            flex-direction: column;
            position: relative;
            background: white;
            border-radius: 6px;
            padding: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 15px;
        }

        .search-input {
            padding: 6px 35px 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 16px;
            font-size: 12px;
            width: 100%;
            outline: none;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .search-input:focus {
            border-color: #007bff;
        }

        .search-button {
            position: absolute;
            right: 10px;
            top: 10px;
            background: #007bff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 11px;
            color: white;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-button:hover {
            background: #0056b3;
        }

        .search-results {
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-results.show {
            display: block;
        }

        .search-result-item {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-mall {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            font-family: monospace;
            font-size: 12px;
        }

        .search-result-modules {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .search-result-module {
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 500;
        }

        .clickable-module {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .clickable-module:hover {
            background: #1976d2;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: 1px solid #1976d2;
        }

        .clickable-module:active {
            transform: translateY(0);
        }

        .no-results {
            padding: 16px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        
        .group-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .acting-title {
            color: #2e7d32;
        }
        
        .inactive-title {
            color: #d32f2f;
        }
        
        .main-group {
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .team-section .main-group {
            margin-bottom: 15px;
            margin-right: 20px;
            margin-left: auto;
            transform: scale(0.95);
            transform-origin: right top;
            width: calc(100% - 40px);
        }
        
        .main-group-header {
            background-color: #f8f9fa;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .team-section .main-group-header {
            padding: 12px 15px;
            font-size: 16px;
        }
        
        .k2k-header { border-left: 4px solid #ff5722; }
        .k2g-header { border-left: 4px solid #2196f3; }
        .g2g-header { border-left: 4px solid #4caf50; }
        
        .subgroups {
            padding: 0;
        }
        
        .subgroup {
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            background-color: white;
            transition: background-color 0.2s;
        }
        
        .team-section .subgroup {
            padding: 10px 18px;
        }
        
        .subgroup:last-child {
            border-bottom: none;
        }
        
        .subgroup:hover {
            background-color: #f9f9f9;
        }
        
        .subgroup-name {
            font-weight: 500;
            color: #555;
        }
        
        .empty-state {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 40px;
        }
        
        .group-count {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 8px;
        }
        
        .module-header {
            background-color: #fff3e0;
            border-left: 4px solid #ff9800;
        }
        
        .work-item {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
            word-wrap: break-word;
        }
        
        .work-code {
            font-family: monospace;
            font-weight: bold;
            color: #333;
        }
        
        .dependency-tag {
            background-color: #ffebee;
            color: #c62828;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .dependency-tag.k2g {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .dependency-tag.g2g {
            background-color: #e8f5e8;
            color: #2e7d32;
        }
        
        .engine-tag {
            background-color: #e1f5fe;
            color: #0277bd;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
        }

        .mall-count-label {
            background-color: #fff3e0;
            color: #e65100;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .mall-count-label:hover {
            background-color: #ffe0b2;
        }

        .mall-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mall-popup-content {
            background: white;
            border-radius: 8px;
            max-width: 600px;
            max-height: 80vh;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .mall-popup-header {
            background-color: #f8f9fa;
            padding: 16px 20px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mall-popup-header h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }

        .mall-popup-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mall-popup-close:hover {
            color: #000;
        }

        .mall-popup-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .mall-list {
            display: grid;
            gap: 8px;
        }

        .mall-item {
            padding: 10px 16px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #e65100;
        }

        .mall-info {
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .mall-info-section {
            margin-top: 12px;
            border-top: 1px solid #e0e0e0;
            padding-top: 8px;
        }

        .mall-info-header {
            cursor: pointer;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
            color: #495057;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .mall-info-header:hover {
            background-color: #e9ecef;
        }

        .mall-count {
            font-size: 0.9em;
            color: #6c757d;
        }

        .mall-collapse-icon {
            font-size: 0.8em;
            transition: transform 0.3s ease;
        }

        .mall-info-header.collapsed .mall-collapse-icon {
            transform: rotate(-90deg);
        }

        .mall-list {
            max-height: 200px;
            overflow-y: auto;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 6px 6px;
            padding: 8px;
            transition: max-height 0.3s ease;
        }

        .mall-list.collapsed {
            max-height: 0;
            overflow: hidden;
            padding: 0 8px;
            border: none;
        }

        .mall-item {
            padding: 4px 8px;
            font-size: 0.8em;
            color: #495057;
            background-color: #f8f9fa;
            margin: 2px 0;
            border-radius: 4px;
            font-family: monospace;
        }
        
        .team-section {
            margin-bottom: 30px;
        }
        
        .team-title {
            font-size: 20px;
            font-weight: bold;
            color: #444;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 8px;
            border-left: 5px solid #6c7ae0;
            cursor: pointer;
            user-select: none;
            position: relative;
        }
        
        .team-title:hover {
            background: linear-gradient(135deg, #e8eaf6 0%, #b39ddb 100%);
        }
        
        .single-work-title {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border-left: 5px solid #f44336;
        }
        
        .single-work-title:hover {
            background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);
        }
        
        .team-collapse-icon {
            float: right;
            font-size: 18px;
            transition: transform 0.3s ease;
        }
        
        .team-collapsed .team-collapse-icon {
            transform: rotate(-90deg);
        }
        
        .team-content {
            max-height: 5000px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .team-content.scrollable {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .team-collapsed .team-content {
            max-height: 0;
        }
        
        .collapsible-header {
            cursor: pointer;
            user-select: none;
            position: relative;
        }
        
        .collapsible-header:hover {
            background-color: #f0f0f0;
        }
        
        .collapse-icon {
            float: right;
            font-size: 16px;
            transition: transform 0.3s ease;
            margin-left: 10px;
        }
        
        .collapsed .collapse-icon {
            transform: rotate(-90deg);
        }
        
        .collapsible-content {
            max-height: 1000px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .collapsed .collapsible-content {
            max-height: 0;
        }
        
        .collapsible-content.expanded {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .collapsible-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .collapsible-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .collapsible-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .collapsible-content::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Two-column layout */
        .dashboard-content {
            display: flex;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .left-panel {
            flex: 1;
            min-width: 600px;
        }

        .right-panel {
            flex: 0 0 380px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #dee2e6;
            height: fit-content;
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }

        .right-panel h2 {
            margin: 0 0 15px 0;
            color: #495057;
            font-size: 16px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 8px;
        }

        /* Management panel styles */
        .management-panel {
            background: white;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #dee2e6;
        }

        .management-panel h3 {
            margin: 0 0 12px 0;
            color: #495057;
            font-size: 14px;
            font-weight: 600;
        }

        /* Action button styles */
        .action-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s;
            margin-top: 5px;
        }

        .action-button:hover {
            background: #0056b3;
        }

        .action-button.add-button {
            background: #28a745;
        }

        .action-button.add-button:hover {
            background: #218838;
        }

        .action-button.delete-button {
            background: #dc3545;
        }

        .action-button.delete-button:hover {
            background: #c82333;
        }

        /* Result message styles */
        .result-message {
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 13px;
            display: none;
        }

        /* Input panel styles */
        .input-panel {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #dee2e6;
        }

        .input-group {
            margin-bottom: 12px;
        }

        .input-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
            color: #495057;
            font-size: 13px;
        }

        .input-group input, .input-group select, .input-field {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 13px;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        .input-group input:focus, .input-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        .submit-button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background: #218838;
        }

        .submit-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .submit-button[style*="background: #dc3545"]:hover {
            background: #c82333 !important;
        }

        /* Adjust header for smaller width */
        .dashboard-header {
            max-width: 1400px;
            margin: 0 auto 20px auto;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1 class="dashboard-title">작업그룹 및 제외현황 관리 대시보드</h1>
        </div>
        
        <div class="dashboard-content">
            <!-- Left Panel: Module Lists -->
            <div class="left-panel">
                <!-- Work Modules Section -->
        <div class="group-section">
            <h2 class="section-title inactive-title">Work Modules</h2>
            

            
            <!-- FAS운영1팀 Section -->
            <div class="team-section team-collapsed">
                <div class="team-title" onclick="toggleTeam(this)">
                    FAS운영1팀
                    <span class="team-collapse-icon">▼</span>
                </div>
                <div class="team-content">
            
            <!-- 기본혜택 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM1 - 기본혜택
                    <span class="group-count">4</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA022</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(127 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">zzann (shop: 1)</div>
                            <div class="mall-item">marineteo (shop: 1)</div>
                            <div class="mall-item">doblab (shop: 1, 5)</div>
                            <div class="mall-item">bromptonmall (shop: 1)</div>
                            <div class="mall-item">sabona (shop: 1)</div>
                            <div class="mall-item">kidsno1 (shop: 1)</div>
                            <div class="mall-item">pluz12 (shop: 1)</div>
                            <div class="mall-item">gopacific (shop: 1)</div>
                            <div class="mall-item">hacie1 (shop: 1)</div>
                            <div class="mall-item">kkliming (shop: 1)</div>
                            <div class="mall-item">phn0808 (shop: 1)</div>
                            <div class="mall-item">santa002 (shop: 1, 2)</div>
                            <div class="mall-item">productonline (shop: 1)</div>
                            <div class="mall-item">sytrend (shop: 1)</div>
                            <div class="mall-item">ntbacon (shop: 1)</div>
                            <div class="mall-item">cedartree26 (shop: 1)</div>
                            <div class="mall-item">funflex (shop: 1, 9)</div>
                            <div class="mall-item">sonnetcorp (shop: 1)</div>
                            <div class="mall-item">yearning128 (shop: 1)</div>
                            <div class="mall-item">heysummerkr (shop: 1)</div>
                            <div class="mall-item">smartmask (shop: 1)</div>
                            <div class="mall-item">colordin (shop: 1)</div>
                            <div class="mall-item">clearlab100 (shop: 1)</div>
                            <div class="mall-item">medireturn (shop: 1)</div>
                            <div class="mall-item">fldakr (shop: 1)</div>
                            <div class="mall-item">lgkhjg (shop: 1, 2)</div>
                            <div class="mall-item">abluerkw (shop: 1)</div>
                            <div class="mall-item">groupys992 (shop: 1)</div>
                            <div class="mall-item">sfriendly (shop: 1)</div>
                            <div class="mall-item">groupys772 (shop: 1)</div>
                            <div class="mall-item">aromaticlabshop (shop: 1)</div>
                            <div class="mall-item">kottiuomo (shop: 1)</div>
                            <div class="mall-item">mytheo411 (shop: 1)</div>
                            <div class="mall-item">ppituru (shop: 1)</div>
                            <div class="mall-item">jksikim7 (shop: 1)</div>
                            <div class="mall-item">odlykr (shop: 1)</div>
                            <div class="mall-item">thedreampartner (shop: 1)</div>
                            <div class="mall-item">veining (shop: 1)</div>
                            <div class="mall-item">plasia22 (shop: 1)</div>
                            <div class="mall-item">skincoding (shop: 1)</div>
                            <div class="mall-item">lapla (shop: 1)</div>
                            <div class="mall-item">broisterkor (shop: 1, 5)</div>
                            <div class="mall-item">acud2025 (shop: 1, 2)</div>
                            <div class="mall-item">formlich (shop: 1)</div>
                            <div class="mall-item">dduk2141 (shop: 1)</div>
                            <div class="mall-item">xrider9221 (shop: 1)</div>
                            <div class="mall-item">drpbg77 (shop: 1)</div>
                            <div class="mall-item">supporty1 (shop: 1)</div>
                            <div class="mall-item">bmuet0119 (shop: 1)</div>
                            <div class="mall-item">artigel (shop: 1)</div>
                            <div class="mall-item">barchive23 (shop: 1)</div>
                            <div class="mall-item">seokyung2030 (shop: 1)</div>
                            <div class="mall-item">jjkids4031 (shop: 10)</div>
                            <div class="mall-item">maruwell12 (shop: 1)</div>
                            <div class="mall-item">brandiz0312 (shop: 1)</div>
                            <div class="mall-item">biggaia77 (shop: 1)</div>
                            <div class="mall-item">kangnam4596 (shop: 1)</div>
                            <div class="mall-item">candlesoapstory (shop: 1, 4, 15)</div>
                            <div class="mall-item">imdoremi (shop: 1)</div>
                            <div class="mall-item">ai1474 (shop: 1, 6)</div>
                            <div class="mall-item">tgfnb5242 (shop: 1)</div>
                            <div class="mall-item">lingseoul2 (shop: 1)</div>
                            <div class="mall-item">mahasukha (shop: 1)</div>
                            <div class="mall-item">tiacom (shop: 2, 3, 6)</div>
                            <div class="mall-item">shyoff (shop: 1)</div>
                            <div class="mall-item">noticevasam (shop: 1)</div>
                            <div class="mall-item">gkduddl2207 (shop: 1)</div>
                            <div class="mall-item">thedaall2 (shop: 1)</div>
                            <div class="mall-item">fabcache (shop: 1)</div>
                            <div class="mall-item">tracy90020 (shop: 1)</div>
                            <div class="mall-item">nightsaren (shop: 1)</div>
                            <div class="mall-item">comfas (shop: 1)</div>
                            <div class="mall-item">romp (shop: 1, 7)</div>
                            <div class="mall-item">equalby (shop: 1)</div>
                            <div class="mall-item">mrcf (shop: 1)</div>
                            <div class="mall-item">groupys993 (shop: 1)</div>
                            <div class="mall-item">wdrobe0507 (shop: 1)</div>
                            <div class="mall-item">mainsun1 (shop: 1)</div>
                            <div class="mall-item">djaaksp9911 (shop: 1)</div>
                            <div class="mall-item">unidiet (shop: 1)</div>
                            <div class="mall-item">phytopecia (shop: 1)</div>
                            <div class="mall-item">few1 (shop: 1)</div>
                            <div class="mall-item">sngy (shop: 1)</div>
                            <div class="mall-item">buty1 (shop: 1)</div>
                            <div class="mall-item">coozinmall (shop: 1)</div>
                            <div class="mall-item">misslab (shop: 1)</div>
                            <div class="mall-item">thesionco (shop: 1, 2)</div>
                            <div class="mall-item">kuroshio83 (shop: 1)</div>
                            <div class="mall-item">alstkd13579 (shop: 1)</div>
                            <div class="mall-item">wadi8002 (shop: 1)</div>
                            <div class="mall-item">piscess1 (shop: 1)</div>
                            <div class="mall-item">bis90 (shop: 1)</div>
                            <div class="mall-item">drumgarage02 (shop: 1)</div>
                            <div class="mall-item">ludojewelry (shop: 1)</div>
                            <div class="mall-item">fractal14 (shop: 1)</div>
                            <div class="mall-item">okmijnpl2535 (shop: 1)</div>
                            <div class="mall-item">grounded (shop: 1)</div>
                            <div class="mall-item">afloral (shop: 1, 7)</div>
                            <div class="mall-item">tokyo123 (shop: 1)</div>
                            <div class="mall-item">flipflower (shop: 1)</div>
                            <div class="mall-item">glamwell (shop: 1)</div>
                            <div class="mall-item">menuad (shop: 1)</div>
                            <div class="mall-item">luff101 (shop: 1)</div>
                            <div class="mall-item">elevenmay (shop: 1)</div>
                            <div class="mall-item">bymisoswim (shop: 1)</div>
                            <div class="mall-item">systempler (shop: 4)</div>
                            <div class="mall-item">ire0 (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">snongline (shop: 1)</div>
                            <div class="mall-item">skyminji7 (shop: 1)</div>
                            <div class="mall-item">minizzang7 (shop: 1)</div>
                            <div class="mall-item">yamagobo1 (shop: 1)</div>
                            <div class="mall-item">haancare1 (shop: 1, 3, 4, 5)</div>
                            <div class="mall-item">mindgood (shop: 1)</div>
                            <div class="mall-item">xmiss2004 (shop: 1)</div>
                            <div class="mall-item">masscon (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 온사이트캠페인 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM2 - 온사이트캠페인
                    <span class="group-count">5</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA087</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA184</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA551</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA552</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA553</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(212 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">ipposong2 (shop: 1)</div>
                            <div class="mall-item">haveainc (shop: 1, 2)</div>
                            <div class="mall-item">brighton00 (shop: 1)</div>
                            <div class="mall-item">bromptonmall (shop: 1)</div>
                            <div class="mall-item">happymajung (shop: 1)</div>
                            <div class="mall-item">raimdrug (shop: 1)</div>
                            <div class="mall-item">mouvepoint (shop: 1, 3)</div>
                            <div class="mall-item">riahfolla (shop: 1)</div>
                            <div class="mall-item">earthmall (shop: 1)</div>
                            <div class="mall-item">housea0912 (shop: 1)</div>
                            <div class="mall-item">nbnlkr (shop: 1)</div>
                            <div class="mall-item">kkliming (shop: 1)</div>
                            <div class="mall-item">phn0808 (shop: 1)</div>
                            <div class="mall-item">jonsstyle (shop: 1)</div>
                            <div class="mall-item">ocoomall83 (shop: 1, 4)</div>
                            <div class="mall-item">jdaidl (shop: 1)</div>
                            <div class="mall-item">gimaummall (shop: 1)</div>
                            <div class="mall-item">urbanpapa (shop: 1)</div>
                            <div class="mall-item">alrokitchen (shop: 1)</div>
                            <div class="mall-item">yearning128 (shop: 1)</div>
                            <div class="mall-item">lyclinc1 (shop: 1, 13)</div>
                            <div class="mall-item">amierkorea (shop: 1, 2, 3)</div>
                            <div class="mall-item">welcare1 (shop: 1)</div>
                            <div class="mall-item">deersm (shop: 1)</div>
                            <div class="mall-item">cici3913 (shop: 1)</div>
                            <div class="mall-item">etheroom (shop: 1)</div>
                            <div class="mall-item">alleno17 (shop: 1)</div>
                            <div class="mall-item">sfriendly (shop: 1)</div>
                            <div class="mall-item">thethis (shop: 1, 6)</div>
                            <div class="mall-item">jennyoverwillow (shop: 1)</div>
                            <div class="mall-item">lazurina001 (shop: 1)</div>
                            <div class="mall-item">melideco (shop: 1, 3)</div>
                            <div class="mall-item">nature0622 (shop: 1)</div>
                            <div class="mall-item">seouli00 (shop: 1)</div>
                            <div class="mall-item">davidhanbiz (shop: 1, 4)</div>
                            <div class="mall-item">faurea (shop: 1)</div>
                            <div class="mall-item">zkxkals1 (shop: 1)</div>
                            <div class="mall-item">yyl033123 (shop: 1, 2)</div>
                            <div class="mall-item">ortho110 (shop: 1)</div>
                            <div class="mall-item">choyeonhong (shop: 1)</div>
                            <div class="mall-item">loveenb (shop: 1, 4)</div>
                            <div class="mall-item">ppituru (shop: 1)</div>
                            <div class="mall-item">plac01 (shop: 1)</div>
                            <div class="mall-item">odlykr (shop: 1)</div>
                            <div class="mall-item">mtgcrew4 (shop: 1)</div>
                            <div class="mall-item">currentbrown (shop: 1)</div>
                            <div class="mall-item">surfea (shop: 1)</div>
                            <div class="mall-item">lapla (shop: 1)</div>
                            <div class="mall-item">ahaps0 (shop: 1)</div>
                            <div class="mall-item">nw4668 (shop: 1)</div>
                            <div class="mall-item">dressvtia (shop: 1, 6)</div>
                            <div class="mall-item">formlich (shop: 1)</div>
                            <div class="mall-item">dduk2141 (shop: 1, 8)</div>
                            <div class="mall-item">howkidsful (shop: 1)</div>
                            <div class="mall-item">ehdudtyd123 (shop: 1)</div>
                            <div class="mall-item">mereconte (shop: 1)</div>
                            <div class="mall-item">dkvorxhfl (shop: 1)</div>
                            <div class="mall-item">xrider9221 (shop: 1)</div>
                            <div class="mall-item">sonokongtoy (shop: 1, 6)</div>
                            <div class="mall-item">foren88 (shop: 1)</div>
                            <div class="mall-item">itiscoolthing (shop: 1)</div>
                            <div class="mall-item">bmuet0119 (shop: 1)</div>
                            <div class="mall-item">lemetier84 (shop: 1)</div>
                            <div class="mall-item">seokyung2030 (shop: 1)</div>
                            <div class="mall-item">nubo (shop: 1)</div>
                            <div class="mall-item">cortte (shop: 1, 5)</div>
                            <div class="mall-item">elchltd002 (shop: 1)</div>
                            <div class="mall-item">yoons0723 (shop: 1)</div>
                            <div class="mall-item">jchardwarestore (shop: 1)</div>
                            <div class="mall-item">lemondetoxkorea1 (shop: 1)</div>
                            <div class="mall-item">dayone5 (shop: 1)</div>
                            <div class="mall-item">lemnos (shop: 1)</div>
                            <div class="mall-item">candlesoapstory (shop: 1, 4, 15)</div>
                            <div class="mall-item">ilhwa1 (shop: 1)</div>
                            <div class="mall-item">eumakplus (shop: 1)</div>
                            <div class="mall-item">rugumsp (shop: 1)</div>
                            <div class="mall-item">aibel0 (shop: 1)</div>
                            <div class="mall-item">ptjcorp (shop: 1, 7)</div>
                            <div class="mall-item">oddville (shop: 1)</div>
                            <div class="mall-item">mahasukha (shop: 1)</div>
                            <div class="mall-item">lalahomekr (shop: 1)</div>
                            <div class="mall-item">kyong3542 (shop: 1)</div>
                            <div class="mall-item">ksk0027 (shop: 1)</div>
                            <div class="mall-item">ksb455 (shop: 1)</div>
                            <div class="mall-item">gkduddl2207 (shop: 1, 6)</div>
                            <div class="mall-item">murrenbeauty (shop: 1, 2)</div>
                            <div class="mall-item">lepisodekorea (shop: 1)</div>
                            <div class="mall-item">bmfa97 (shop: 1, 6)</div>
                            <div class="mall-item">muhan88 (shop: 1, 5)</div>
                            <div class="mall-item">thedaall2 (shop: 1)</div>
                            <div class="mall-item">studiogarin1 (shop: 1)</div>
                            <div class="mall-item">dooodle (shop: 1)</div>
                            <div class="mall-item">tsuvary (shop: 1)</div>
                            <div class="mall-item">buddyboo (shop: 1, 2)</div>
                            <div class="mall-item">edu25h (shop: 1, 5)</div>
                            <div class="mall-item">convenii (shop: 1, 6)</div>
                            <div class="mall-item">colorun (shop: 1, 2)</div>
                            <div class="mall-item">kdhmall2020 (shop: 1)</div>
                            <div class="mall-item">comfas (shop: 1)</div>
                            <div class="mall-item">snpeshop (shop: 1)</div>
                            <div class="mall-item">mocmo24 (shop: 1)</div>
                            <div class="mall-item">romp (shop: 1, 7)</div>
                            <div class="mall-item">beaudamo (shop: 1)</div>
                            <div class="mall-item">jungjikmall2 (shop: 1)</div>
                            <div class="mall-item">mcgun (shop: 1, 2)</div>
                            <div class="mall-item">wnsgh13077 (shop: 1)</div>
                            <div class="mall-item">mrcf (shop: 1)</div>
                            <div class="mall-item">bysec2022 (shop: 1, 7)</div>
                            <div class="mall-item">ideacrew8434 (shop: 1)</div>
                            <div class="mall-item">wdrobe0507 (shop: 1)</div>
                            <div class="mall-item">gnlwns1504 (shop: 1)</div>
                            <div class="mall-item">negativethree3 (shop: 1)</div>
                            <div class="mall-item">alsdud0810 (shop: 1)</div>
                            <div class="mall-item">chinni22 (shop: 1)</div>
                            <div class="mall-item">trendpick00 (shop: 1, 2)</div>
                            <div class="mall-item">muziktiger (shop: 1)</div>
                            <div class="mall-item">bogobiomall (shop: 1, 2)</div>
                            <div class="mall-item">coozinmall (shop: 1, 3)</div>
                            <div class="mall-item">wingbling (shop: 1, 12)</div>
                            <div class="mall-item">moveaura (shop: 1)</div>
                            <div class="mall-item">c9ttang (shop: 1)</div>
                            <div class="mall-item">hiwons (shop: 1)</div>
                            <div class="mall-item">pestoyoil (shop: 1, 3)</div>
                            <div class="mall-item">acebiome1234 (shop: 1)</div>
                            <div class="mall-item">organiccyclean (shop: 1)</div>
                            <div class="mall-item">hosanna83 (shop: 1, 2)</div>
                            <div class="mall-item">aromame77 (shop: 1)</div>
                            <div class="mall-item">narostar (shop: 1)</div>
                            <div class="mall-item">alstkd13579 (shop: 1)</div>
                            <div class="mall-item">brmudkorea (shop: 1)</div>
                            <div class="mall-item">daehwa01 (shop: 1)</div>
                            <div class="mall-item">knifemall1 (shop: 1, 3)</div>
                            <div class="mall-item">fractal14 (shop: 1)</div>
                            <div class="mall-item">changefit1 (shop: 1)</div>
                            <div class="mall-item">mysellkr (shop: 1)</div>
                            <div class="mall-item">eaahofficial (shop: 1)</div>
                            <div class="mall-item">xxixx0580 (shop: 1, 5, 6)</div>
                            <div class="mall-item">imallpmg (shop: 1)</div>
                            <div class="mall-item">useit (shop: 1)</div>
                            <div class="mall-item">nobigdeal2022 (shop: 1)</div>
                            <div class="mall-item">afloral (shop: 1, 7)</div>
                            <div class="mall-item">guildstore (shop: 1)</div>
                            <div class="mall-item">supernova2012 (shop: 1)</div>
                            <div class="mall-item">hipeekaboo (shop: 1)</div>
                            <div class="mall-item">son4368 (shop: 1)</div>
                            <div class="mall-item">ubsstore4377 (shop: 1)</div>
                            <div class="mall-item">ubsstore4378 (shop: 1)</div>
                            <div class="mall-item">crewlinks (shop: 1)</div>
                            <div class="mall-item">rawrow (shop: 1)</div>
                            <div class="mall-item">menuad (shop: 1)</div>
                            <div class="mall-item">goodorverygood (shop: 1)</div>
                            <div class="mall-item">kind3312 (shop: 1)</div>
                            <div class="mall-item">luff101 (shop: 1)</div>
                            <div class="mall-item">sinsia1024 (shop: 1)</div>
                            <div class="mall-item">ire0 (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">chairchair (shop: 1)</div>
                            <div class="mall-item">snongline (shop: 1)</div>
                            <div class="mall-item">fngbelab (shop: 1)</div>
                            <div class="mall-item">ballvic (shop: 1, 7)</div>
                            <div class="mall-item">minizzang7 (shop: 1, 2)</div>
                            <div class="mall-item">pfpp (shop: 1)</div>
                            <div class="mall-item">haancare1 (shop: 1, 3, 4, 5)</div>
                            <div class="mall-item">coffeehc (shop: 1)</div>
                            <div class="mall-item">ebur2231 (shop: 1)</div>
                            <div class="mall-item">waverock5 (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SMS 발송 캠페인 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM3 - SMS 발송 캠페인
                    <span class="group-count">5</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA012</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA013</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA016</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA221</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(62 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">rollendar (shop: 1)</div>
                            <div class="mall-item">eastblue8282 (shop: 1)</div>
                            <div class="mall-item">mivrine (shop: 1)</div>
                            <div class="mall-item">richgirlcafe (shop: 1)</div>
                            <div class="mall-item">workonit (shop: 1)</div>
                            <div class="mall-item">jdaidl (shop: 1)</div>
                            <div class="mall-item">productonline (shop: 1)</div>
                            <div class="mall-item">admdada (shop: 1, 4)</div>
                            <div class="mall-item">allbe11 (shop: 1)</div>
                            <div class="mall-item">alrokitchen (shop: 1)</div>
                            <div class="mall-item">goodthinkmall (shop: 1)</div>
                            <div class="mall-item">ngumall (shop: 1)</div>
                            <div class="mall-item">ari240201 (shop: 1)</div>
                            <div class="mall-item">cici3913 (shop: 1)</div>
                            <div class="mall-item">lazurina001 (shop: 1)</div>
                            <div class="mall-item">aromaticlabshop (shop: 1)</div>
                            <div class="mall-item">sktea (shop: 1)</div>
                            <div class="mall-item">jtesoro103 (shop: 1)</div>
                            <div class="mall-item">surfea (shop: 1)</div>
                            <div class="mall-item">wriggling (shop: 1)</div>
                            <div class="mall-item">shin25641 (shop: 1)</div>
                            <div class="mall-item">ch0i3180 (shop: 1)</div>
                            <div class="mall-item">drpbg77 (shop: 1)</div>
                            <div class="mall-item">dcollec (shop: 1)</div>
                            <div class="mall-item">jjkids4031 (shop: 10)</div>
                            <div class="mall-item">moden12345 (shop: 1, 3)</div>
                            <div class="mall-item">brandiz0312 (shop: 1)</div>
                            <div class="mall-item">themoon85 (shop: 1)</div>
                            <div class="mall-item">dayone5 (shop: 1)</div>
                            <div class="mall-item">eumakplus (shop: 1)</div>
                            <div class="mall-item">instinctus1 (shop: 1)</div>
                            <div class="mall-item">eminandpaul75 (shop: 1)</div>
                            <div class="mall-item">fobico (shop: 1)</div>
                            <div class="mall-item">oddville (shop: 1)</div>
                            <div class="mall-item">teddytales (shop: 1, 3)</div>
                            <div class="mall-item">gripswany (shop: 1)</div>
                            <div class="mall-item">dressuad (shop: 1)</div>
                            <div class="mall-item">dooodle (shop: 1)</div>
                            <div class="mall-item">juyabet (shop: 1)</div>
                            <div class="mall-item">kdhmall2020 (shop: 1)</div>
                            <div class="mall-item">mocmo24 (shop: 1)</div>
                            <div class="mall-item">jungjikmall2 (shop: 1)</div>
                            <div class="mall-item">wdrobe0507 (shop: 1)</div>
                            <div class="mall-item">levdance (shop: 1)</div>
                            <div class="mall-item">sr101 (shop: 1)</div>
                            <div class="mall-item">mev706 (shop: 1)</div>
                            <div class="mall-item">muziktiger (shop: 1)</div>
                            <div class="mall-item">hiwons (shop: 1)</div>
                            <div class="mall-item">onzak (shop: 1)</div>
                            <div class="mall-item">legodtofficial (shop: 1)</div>
                            <div class="mall-item">brooksbrothers (shop: 1)</div>
                            <div class="mall-item">lifeofficial (shop: 4)</div>
                            <div class="mall-item">organiccyclean (shop: 1)</div>
                            <div class="mall-item">dalbangoo12 (shop: 1)</div>
                            <div class="mall-item">mysellkr (shop: 1)</div>
                            <div class="mall-item">eaahofficial (shop: 1)</div>
                            <div class="mall-item">piumuniform1 (shop: 1)</div>
                            <div class="mall-item">nobigdeal2022 (shop: 1)</div>
                            <div class="mall-item">guildstore (shop: 1)</div>
                            <div class="mall-item">supernova2012 (shop: 1)</div>
                            <div class="mall-item">goodorverygood (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 친구톡 캠페인 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM4 - 친구톡 캠페인
                    <span class="group-count">10</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA007</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA014</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA025</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA027</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA028</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA029</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA030</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA085</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA093</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(109 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">gopacific (shop: 1)</div>
                            <div class="mall-item">mivrine (shop: 1)</div>
                            <div class="mall-item">nbnlkr (shop: 1)</div>
                            <div class="mall-item">richgirlcafe (shop: 1)</div>
                            <div class="mall-item">kkotppang1622 (shop: 1)</div>
                            <div class="mall-item">phn0808 (shop: 1)</div>
                            <div class="mall-item">lovelingjewelry (shop: 1)</div>
                            <div class="mall-item">workonit (shop: 1)</div>
                            <div class="mall-item">jdaidl (shop: 1)</div>
                            <div class="mall-item">productonline (shop: 1)</div>
                            <div class="mall-item">urbanpapa (shop: 1)</div>
                            <div class="mall-item">admdada (shop: 1, 4)</div>
                            <div class="mall-item">kindabite (shop: 1)</div>
                            <div class="mall-item">alrokitchen (shop: 1)</div>
                            <div class="mall-item">goodthinkmall (shop: 1)</div>
                            <div class="mall-item">moire2930 (shop: 1)</div>
                            <div class="mall-item">ngumall (shop: 1)</div>
                            <div class="mall-item">txorbs96 (shop: 1)</div>
                            <div class="mall-item">ari240201 (shop: 1)</div>
                            <div class="mall-item">cici3913 (shop: 1)</div>
                            <div class="mall-item">maisseoul (shop: 1)</div>
                            <div class="mall-item">lazurina001 (shop: 1)</div>
                            <div class="mall-item">admin19 (shop: 1)</div>
                            <div class="mall-item">paulsboutique1 (shop: 1)</div>
                            <div class="mall-item">mytheo411 (shop: 1)</div>
                            <div class="mall-item">zkxkals1 (shop: 1)</div>
                            <div class="mall-item">yyl033123 (shop: 1)</div>
                            <div class="mall-item">ortho110 (shop: 1)</div>
                            <div class="mall-item">sktea (shop: 1)</div>
                            <div class="mall-item">jtesoro103 (shop: 1)</div>
                            <div class="mall-item">dongwha7112 (shop: 1)</div>
                            <div class="mall-item">surfea (shop: 1)</div>
                            <div class="mall-item">teeth319 (shop: 1)</div>
                            <div class="mall-item">commonnuovo1 (shop: 1)</div>
                            <div class="mall-item">wriggling (shop: 1)</div>
                            <div class="mall-item">shin25641 (shop: 1)</div>
                            <div class="mall-item">doodress (shop: 1)</div>
                            <div class="mall-item">cacle09 (shop: 1)</div>
                            <div class="mall-item">ch0i3180 (shop: 1)</div>
                            <div class="mall-item">drpbg77 (shop: 1)</div>
                            <div class="mall-item">foren88 (shop: 1)</div>
                            <div class="mall-item">dcollec (shop: 1)</div>
                            <div class="mall-item">jjkids4031 (shop: 10)</div>
                            <div class="mall-item">moden12345 (shop: 1, 3)</div>
                            <div class="mall-item">ddalku79 (shop: 1)</div>
                            <div class="mall-item">brandiz0312 (shop: 1)</div>
                            <div class="mall-item">themoon85 (shop: 1)</div>
                            <div class="mall-item">jchardwarestore (shop: 1)</div>
                            <div class="mall-item">dayone5 (shop: 1)</div>
                            <div class="mall-item">lemnos (shop: 1)</div>
                            <div class="mall-item">eumakplus (shop: 1)</div>
                            <div class="mall-item">rugumsp (shop: 1)</div>
                            <div class="mall-item">bilybabybily (shop: 1)</div>
                            <div class="mall-item">instinctus1 (shop: 1)</div>
                            <div class="mall-item">eminandpaul75 (shop: 1)</div>
                            <div class="mall-item">viare0 (shop: 1)</div>
                            <div class="mall-item">elizabeth88admin (shop: 1)</div>
                            <div class="mall-item">fobico (shop: 1)</div>
                            <div class="mall-item">oddville (shop: 1)</div>
                            <div class="mall-item">muhan88 (shop: 1, 5)</div>
                            <div class="mall-item">teddytales (shop: 1, 3)</div>
                            <div class="mall-item">gripswany (shop: 1, 2)</div>
                            <div class="mall-item">dressuad (shop: 1)</div>
                            <div class="mall-item">dooodle (shop: 1)</div>
                            <div class="mall-item">omittedkr (shop: 1, 4)</div>
                            <div class="mall-item">juyabet (shop: 1)</div>
                            <div class="mall-item">kdhmall2020 (shop: 1)</div>
                            <div class="mall-item">mocmo24 (shop: 1)</div>
                            <div class="mall-item">jungjikmall2 (shop: 1)</div>
                            <div class="mall-item">levdance (shop: 1)</div>
                            <div class="mall-item">hoyeonnn12 (shop: 1, 2)</div>
                            <div class="mall-item">sr101 (shop: 1)</div>
                            <div class="mall-item">mev706 (shop: 1)</div>
                            <div class="mall-item">muziktiger (shop: 1)</div>
                            <div class="mall-item">coozinmall (shop: 1)</div>
                            <div class="mall-item">hiwons (shop: 1)</div>
                            <div class="mall-item">onzak (shop: 1)</div>
                            <div class="mall-item">legodtofficial (shop: 1)</div>
                            <div class="mall-item">brooksbrothers (shop: 1)</div>
                            <div class="mall-item">lifeofficial (shop: 4)</div>
                            <div class="mall-item">organiccyclean (shop: 1)</div>
                            <div class="mall-item">kiehif (shop: 1)</div>
                            <div class="mall-item">aromame77 (shop: 1)</div>
                            <div class="mall-item">harugonggan (shop: 1)</div>
                            <div class="mall-item">daehwa01 (shop: 1)</div>
                            <div class="mall-item">dalbangoo12 (shop: 1)</div>
                            <div class="mall-item">mysellkr (shop: 1)</div>
                            <div class="mall-item">eaahofficial (shop: 1)</div>
                            <div class="mall-item">piumuniform1 (shop: 1)</div>
                            <div class="mall-item">nobigdeal2022 (shop: 1)</div>
                            <div class="mall-item">chaewoodak (shop: 1)</div>
                            <div class="mall-item">guildstore (shop: 1)</div>
                            <div class="mall-item">supernova2012 (shop: 1)</div>
                            <div class="mall-item">flipflower (shop: 1)</div>
                            <div class="mall-item">ubsstore4377 (shop: 1)</div>
                            <div class="mall-item">goodorverygood (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">lijamong18 (shop: 1)</div>
                            <div class="mall-item">collagekorea (shop: 1)</div>
                            <div class="mall-item">masscon (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 기본혜택 + 온사이트캠페인 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM5 - 기본혜택 + 온사이트캠페인
                    <span class="group-count">9</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA022</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA087</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA184</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA551</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA552</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA553</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(6 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">ninestar01 (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">fornurse1004 (shop: 1)</div>
                            <div class="mall-item">waverock5 (shop: 1)</div>
                            <div class="mall-item">equalife (shop: 1)</div>
                            <div class="mall-item">yangbongnh (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 쿠폰/적립금 (기본혜택 + 친구톡 캠페인(5개)) Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRM6 - 쿠폰/적립금 (기본혜택 + 친구톡 캠페인(5개))
                    <span class="group-count">9</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA007</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA022</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA025</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA085</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA093</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(127 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">brighton00 (shop: 1)</div>
                            <div class="mall-item">snugu (shop: 1)</div>
                            <div class="mall-item">oymrunning (shop: 1)</div>
                            <div class="mall-item">housea0912 (shop: 1)</div>
                            <div class="mall-item">nbnlkr (shop: 1)</div>
                            <div class="mall-item">richgirlcafe (shop: 1)</div>
                            <div class="mall-item">kkotppang1622 (shop: 1)</div>
                            <div class="mall-item">ocoomall83 (shop: 1, 4)</div>
                            <div class="mall-item">workonit (shop: 1)</div>
                            <div class="mall-item">bitnaluk (shop: 1)</div>
                            <div class="mall-item">jdaidl (shop: 1)</div>
                            <div class="mall-item">alrokitchen (shop: 1)</div>
                            <div class="mall-item">goodthinkmall (shop: 1)</div>
                            <div class="mall-item">amierkorea (shop: 1, 2)</div>
                            <div class="mall-item">ngumall (shop: 1)</div>
                            <div class="mall-item">welcare1 (shop: 1)</div>
                            <div class="mall-item">ari240201 (shop: 1)</div>
                            <div class="mall-item">dbxhd5453 (shop: 1)</div>
                            <div class="mall-item">lazurina001 (shop: 1)</div>
                            <div class="mall-item">monopen (shop: 1)</div>
                            <div class="mall-item">admin19 (shop: 1)</div>
                            <div class="mall-item">davidhanbiz (shop: 1, 4)</div>
                            <div class="mall-item">kottiuomo (shop: 1)</div>
                            <div class="mall-item">zkxkals1 (shop: 1)</div>
                            <div class="mall-item">yyl033123 (shop: 1)</div>
                            <div class="mall-item">ortho110 (shop: 1)</div>
                            <div class="mall-item">dongwha7112 (shop: 1)</div>
                            <div class="mall-item">odlykr (shop: 1)</div>
                            <div class="mall-item">mtgcrew4 (shop: 1)</div>
                            <div class="mall-item">currentbrown (shop: 1)</div>
                            <div class="mall-item">surfea (shop: 1)</div>
                            <div class="mall-item">ahaps0 (shop: 1)</div>
                            <div class="mall-item">yepooni71 (shop: 1)</div>
                            <div class="mall-item">jungmin5709 (shop: 1, 4)</div>
                            <div class="mall-item">dressvtia (shop: 1, 6)</div>
                            <div class="mall-item">teeth319 (shop: 1)</div>
                            <div class="mall-item">commonnuovo1 (shop: 1)</div>
                            <div class="mall-item">wriggling (shop: 1)</div>
                            <div class="mall-item">shin25641 (shop: 1)</div>
                            <div class="mall-item">doodress (shop: 1)</div>
                            <div class="mall-item">dkvorxhfl (shop: 1)</div>
                            <div class="mall-item">cacle09 (shop: 1)</div>
                            <div class="mall-item">ch0i3180 (shop: 1)</div>
                            <div class="mall-item">xrider9221 (shop: 1)</div>
                            <div class="mall-item">vorio01 (shop: 1, 5)</div>
                            <div class="mall-item">supporty1 (shop: 1)</div>
                            <div class="mall-item">foren88 (shop: 1)</div>
                            <div class="mall-item">dcollec (shop: 1)</div>
                            <div class="mall-item">jjkids4031 (shop: 10)</div>
                            <div class="mall-item">moden12345 (shop: 1, 3)</div>
                            <div class="mall-item">ddalku79 (shop: 1)</div>
                            <div class="mall-item">brandiz0312 (shop: 1)</div>
                            <div class="mall-item">yoons0723 (shop: 1)</div>
                            <div class="mall-item">jchardwarestore (shop: 1)</div>
                            <div class="mall-item">dayone5 (shop: 1)</div>
                            <div class="mall-item">lemnos (shop: 1)</div>
                            <div class="mall-item">ilhwa1 (shop: 1)</div>
                            <div class="mall-item">eumakplus (shop: 1)</div>
                            <div class="mall-item">eminandpaul75 (shop: 1)</div>
                            <div class="mall-item">tgfnb5242 (shop: 1)</div>
                            <div class="mall-item">viare0 (shop: 1)</div>
                            <div class="mall-item">fobico (shop: 1)</div>
                            <div class="mall-item">ptjcorp (shop: 1, 7)</div>
                            <div class="mall-item">oddville (shop: 1)</div>
                            <div class="mall-item">tiacom (shop: 2, 3, 6)</div>
                            <div class="mall-item">murrenbeauty (shop: 1, 2)</div>
                            <div class="mall-item">lepisodekorea (shop: 1)</div>
                            <div class="mall-item">muhan88 (shop: 1, 5)</div>
                            <div class="mall-item">teddytales (shop: 1, 3)</div>
                            <div class="mall-item">gripswany (shop: 1, 2)</div>
                            <div class="mall-item">dressuad (shop: 1)</div>
                            <div class="mall-item">dooodle (shop: 1)</div>
                            <div class="mall-item">omittedkr (shop: 1, 4)</div>
                            <div class="mall-item">juyabet (shop: 1)</div>
                            <div class="mall-item">convenii (shop: 1, 6)</div>
                            <div class="mall-item">kdhmall2020 (shop: 1)</div>
                            <div class="mall-item">mocmo24 (shop: 1)</div>
                            <div class="mall-item">diditinc (shop: 3)</div>
                            <div class="mall-item">jungjikmall2 (shop: 1)</div>
                            <div class="mall-item">levdance (shop: 1)</div>
                            <div class="mall-item">keoin92 (shop: 1)</div>
                            <div class="mall-item">sr101 (shop: 1)</div>
                            <div class="mall-item">mev706 (shop: 1)</div>
                            <div class="mall-item">muziktiger (shop: 1)</div>
                            <div class="mall-item">hiwons (shop: 1)</div>
                            <div class="mall-item">onzak (shop: 1)</div>
                            <div class="mall-item">legodtofficial (shop: 1)</div>
                            <div class="mall-item">brooksbrothers (shop: 1)</div>
                            <div class="mall-item">rockportbki (shop: 1)</div>
                            <div class="mall-item">odenserepresent (shop: 1)</div>
                            <div class="mall-item">lifeofficial (shop: 4)</div>
                            <div class="mall-item">pyrenexhome (shop: 1)</div>
                            <div class="mall-item">lakai1922 (shop: 1)</div>
                            <div class="mall-item">organiccyclean (shop: 1)</div>
                            <div class="mall-item">aromame77 (shop: 1)</div>
                            <div class="mall-item">genieiphone (shop: 4)</div>
                            <div class="mall-item">harugonggan (shop: 1)</div>
                            <div class="mall-item">dalbangoo12 (shop: 1)</div>
                            <div class="mall-item">mysellkr (shop: 1)</div>
                            <div class="mall-item">eaahofficial (shop: 1)</div>
                            <div class="mall-item">toolroad (shop: 1)</div>
                            <div class="mall-item">piumuniform1 (shop: 1)</div>
                            <div class="mall-item">xxixx0580 (shop: 1)</div>
                            <div class="mall-item">nobigdeal2022 (shop: 1)</div>
                            <div class="mall-item">supernova2012 (shop: 1)</div>
                            <div class="mall-item">ubsstore4377 (shop: 1)</div>
                            <div class="mall-item">goodorverygood (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">lijamong18 (shop: 1)</div>
                            <div class="mall-item">collagekorea (shop: 1)</div>
                            <div class="mall-item">haancare1 (shop: 1, 3, 4, 5)</div>
                            <div class="mall-item">coffeehc (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PRMTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PRMTKK - K2K 프로모션/CRM 전체
                    <span class="group-count">31</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG004</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA007</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA010</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA012</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA013</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA014</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA016</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA022</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA024</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA025</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA027</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA028</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA029</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA030</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA085</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA087</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA092</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA093</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA107</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA184</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA199</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA200</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA221</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA551</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA552</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA553</div>
                    </div>
                    
                    <!-- PRMTKK Mall Information -->
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(169 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">brighton00 (shop: 1)</div>
                            <div class="mall-item">shamel8286 (shop: 1)</div>
                            <div class="mall-item">mouvepoint (shop: 1)</div>
                            <div class="mall-item">gopacific (shop: 1)</div>
                            <div class="mall-item">riahfolla (shop: 1)</div>
                            <div class="mall-item">mivrine (shop: 1)</div>
                            <div class="mall-item">housea0912 (shop: 1)</div>
                            <div class="mall-item">kkliming (shop: 1)</div>
                            <div class="mall-item">richgirlcafe (shop: 1)</div>
                            <div class="mall-item">ryqhrahf (shop: 1, 2, 7)</div>
                            <div class="mall-item">jonsstyle (shop: 1)</div>
                            <div class="mall-item">workonit (shop: 1)</div>
                            <div class="mall-item">gimaummall (shop: 1)</div>
                            <div class="mall-item">productonline (shop: 1)</div>
                            <div class="mall-item">urbanpapa (shop: 1)</div>
                            <div class="mall-item">hs9779 (shop: 1)</div>
                            <div class="mall-item">ninestar01 (shop: 1)</div>
                            <div class="mall-item">alrokitchen (shop: 1)</div>
                            <div class="mall-item">yearning128 (shop: 1)</div>
                            <div class="mall-item">goodthinkmall (shop: 1)</div>
                            <div class="mall-item">lyclinc1 (shop: 1)</div>
                            <div class="mall-item">ngumall (shop: 1)</div>
                            <div class="mall-item">deersm (shop: 1)</div>
                            <div class="mall-item">ari240201 (shop: 1)</div>
                            <div class="mall-item">etheroom (shop: 1)</div>
                            <div class="mall-item">sp89114 (shop: 1)</div>
                            <div class="mall-item">thethis (shop: 1, 6)</div>
                            <div class="mall-item">jennyoverwillow (shop: 1)</div>
                            <div class="mall-item">lazurina001 (shop: 1)</div>
                            <div class="mall-item">melideco (shop: 1)</div>
                            <div class="mall-item">nature0622 (shop: 1)</div>
                            <div class="mall-item">seouli00 (shop: 1)</div>
                            <div class="mall-item">spcare01 (shop: 1, 2)</div>
                            <div class="mall-item">gpoutdoors (shop: 1)</div>
                            <div class="mall-item">jtesoro103 (shop: 1)</div>
                            <div class="mall-item">ppituru (shop: 1)</div>
                            <div class="mall-item">plac01 (shop: 1)</div>
                            <div class="mall-item">toweljongga (shop: 1)</div>
                            <div class="mall-item">mtgcrew4 (shop: 1)</div>
                            <div class="mall-item">skincoding (shop: 1)</div>
                            <div class="mall-item">surfea (shop: 1)</div>
                            <div class="mall-item">nw4668 (shop: 1)</div>
                            <div class="mall-item">artplex (shop: 1)</div>
                            <div class="mall-item">dduk2141 (shop: 1)</div>
                            <div class="mall-item">wriggling (shop: 1)</div>
                            <div class="mall-item">howkidsful (shop: 1)</div>
                            <div class="mall-item">shin25641 (shop: 1)</div>
                            <div class="mall-item">ehdudtyd123 (shop: 1)</div>
                            <div class="mall-item">ch0i3180 (shop: 1)</div>
                            <div class="mall-item">sonokongtoy (shop: 1)</div>
                            <div class="mall-item">dcollec (shop: 1)</div>
                            <div class="mall-item">bmuet0119 (shop: 1)</div>
                            <div class="mall-item">seokyung2030 (shop: 1)</div>
                            <div class="mall-item">maruwell12 (shop: 1)</div>
                            <div class="mall-item">nubo (shop: 1)</div>
                            <div class="mall-item">cortte (shop: 1)</div>
                            <div class="mall-item">elchltd002 (shop: 1)</div>
                            <div class="mall-item">livinbalance (shop: 1)</div>
                            <div class="mall-item">dayone5 (shop: 1)</div>
                            <div class="mall-item">lemnos (shop: 1)</div>
                            <div class="mall-item">candlesoapstory (shop: 1, 4, 15)</div>
                            <div class="mall-item">eumakplus (shop: 1)</div>
                            <div class="mall-item">bilybabybily (shop: 1)</div>
                            <div class="mall-item">eminandpaul75 (shop: 1)</div>
                            <div class="mall-item">fobico (shop: 1)</div>
                            <div class="mall-item">oddville (shop: 1)</div>
                            <div class="mall-item">mahasukha (shop: 1)</div>
                            <div class="mall-item">kyong3542 (shop: 1)</div>
                            <div class="mall-item">beadstamin (shop: 1, 4)</div>
                            <div class="mall-item">shyoff (shop: 1)</div>
                            <div class="mall-item">ksk0027 (shop: 1)</div>
                            <div class="mall-item">ksb455 (shop: 1)</div>
                            <div class="mall-item">gkduddl2207 (shop: 1)</div>
                            <div class="mall-item">bmfa97 (shop: 1)</div>
                            <div class="mall-item">goldrony (shop: 1)</div>
                            <div class="mall-item">muhan88 (shop: 1)</div>
                            <div class="mall-item">thedaall2 (shop: 1)</div>
                            <div class="mall-item">teddytales (shop: 1, 3)</div>
                            <div class="mall-item">dressuad (shop: 1)</div>
                            <div class="mall-item">moospo (shop: 1)</div>
                            <div class="mall-item">alzkql2 (shop: 1)</div>
                            <div class="mall-item">buddyboo (shop: 1)</div>
                            <div class="mall-item">juyabet (shop: 1)</div>
                            <div class="mall-item">edu25h (shop: 1, 5)</div>
                            <div class="mall-item">colorun (shop: 1)</div>
                            <div class="mall-item">comfas (shop: 1)</div>
                            <div class="mall-item">mocmo24 (shop: 1)</div>
                            <div class="mall-item">romp (shop: 1, 7)</div>
                            <div class="mall-item">mrcf (shop: 1)</div>
                            <div class="mall-item">fingerheel (shop: 1)</div>
                            <div class="mall-item">ideacrew8434 (shop: 1)</div>
                            <div class="mall-item">yousunwkd777 (shop: 1)</div>
                            <div class="mall-item">gnlwns1504 (shop: 1)</div>
                            <div class="mall-item">negativethree3 (shop: 1)</div>
                            <div class="mall-item">alsdud0810 (shop: 1)</div>
                            <div class="mall-item">igotprice (shop: 1)</div>
                            <div class="mall-item">levdance (shop: 1)</div>
                            <div class="mall-item">heriter (shop: 1)</div>
                            <div class="mall-item">chinni22 (shop: 1)</div>
                            <div class="mall-item">sr101 (shop: 1)</div>
                            <div class="mall-item">mev706 (shop: 1)</div>
                            <div class="mall-item">trendpick00 (shop: 1)</div>
                            <div class="mall-item">muziktiger (shop: 1)</div>
                            <div class="mall-item">bogobiomall (shop: 1, 2)</div>
                            <div class="mall-item">coozinmall (shop: 1)</div>
                            <div class="mall-item">moveaura (shop: 1)</div>
                            <div class="mall-item">hiwons (shop: 1)</div>
                            <div class="mall-item">onzak (shop: 1)</div>
                            <div class="mall-item">na820617 (shop: 1)</div>
                            <div class="mall-item">hosanna83 (shop: 1, 2)</div>
                            <div class="mall-item">narostar (shop: 1)</div>
                            <div class="mall-item">alstkd13579 (shop: 1)</div>
                            <div class="mall-item">karman0826 (shop: 1, 8)</div>
                            <div class="mall-item">brmudkorea (shop: 1)</div>
                            <div class="mall-item">knifemall1 (shop: 1)</div>
                            <div class="mall-item">fractal14 (shop: 1)</div>
                            <div class="mall-item">changefit1 (shop: 1)</div>
                            <div class="mall-item">eaahofficial (shop: 1)</div>
                            <div class="mall-item">tuobag (shop: 1)</div>
                            <div class="mall-item">grounded (shop: 1)</div>
                            <div class="mall-item">xxixx0580 (shop: 1)</div>
                            <div class="mall-item">imallpmg (shop: 1)</div>
                            <div class="mall-item">useit (shop: 1)</div>
                            <div class="mall-item">nobigdeal2022 (shop: 1)</div>
                            <div class="mall-item">afloral (shop: 1, 7)</div>
                            <div class="mall-item">guildstore (shop: 1)</div>
                            <div class="mall-item">supernova2012 (shop: 1)</div>
                            <div class="mall-item">hipeekaboo (shop: 1)</div>
                            <div class="mall-item">son4368 (shop: 1)</div>
                            <div class="mall-item">ubsstore4377 (shop: 1)</div>
                            <div class="mall-item">ubsstore4378 (shop: 1)</div>
                            <div class="mall-item">crewlinks (shop: 1)</div>
                            <div class="mall-item">rawrow (shop: 1)</div>
                            <div class="mall-item">menuad (shop: 1)</div>
                            <div class="mall-item">goodorverygood (shop: 1)</div>
                            <div class="mall-item">luff101 (shop: 1)</div>
                            <div class="mall-item">sinsia1024 (shop: 1)</div>
                            <div class="mall-item">elevenmay (shop: 1, 5)</div>
                            <div class="mall-item">jungsungeun (shop: 1)</div>
                            <div class="mall-item">ire0 (shop: 1)</div>
                            <div class="mall-item">designheal (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">ozonz (shop: 1)</div>
                            <div class="mall-item">furnituredotcom (shop: 1)</div>
                            <div class="mall-item">chairchair (shop: 1)</div>
                            <div class="mall-item">fornurse1004 (shop: 1)</div>
                            <div class="mall-item">lijamong18 (shop: 1)</div>
                            <div class="mall-item">snongline (shop: 1)</div>
                            <div class="mall-item">fngbelab (shop: 1)</div>
                            <div class="mall-item">skyminji7 (shop: 1)</div>
                            <div class="mall-item">ballvic (shop: 1, 7)</div>
                            <div class="mall-item">minizzang7 (shop: 1)</div>
                            <div class="mall-item">mindgood (shop: 1)</div>
                            <div class="mall-item">xmiss2004 (shop: 1)</div>
                            <div class="mall-item">waverock5 (shop: 1)</div>
                            <div class="mall-item">equalife (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div> <!-- End team-content -->
            </div> <!-- End FAS운영1팀 -->
            
            <!-- FAS운영2팀 Section -->
            <div class="team-section team-collapsed">
                <div class="team-title" onclick="toggleTeam(this)">
                    FAS운영2팀
                    <span class="team-collapse-icon">▼</span>
                </div>
                <div class="team-content">
            
            <!-- CSTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    CSTKK - CS 전체
                    <span class="group-count">14</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG006</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA045</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA047</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA049</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA050</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA125</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA179</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA180</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA181</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA182</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA230</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">MO010</div>
                    </div>
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(12 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">brighton00 (shop: 1)</div>
                            <div class="mall-item">premale (shop: 1)</div>
                            <div class="mall-item">dooodle (shop: 1)</div>
                            <div class="mall-item">kdhmall2020 (shop: 1)</div>
                            <div class="mall-item">fractal14 (shop: 1)</div>
                            <div class="mall-item">mysellkr (shop: 1)</div>
                            <div class="mall-item">ubsstore4377 (shop: 1)</div>
                            <div class="mall-item">ubsstore4378 (shop: 1)</div>
                            <div class="mall-item">rawrow (shop: 1)</div>
                            <div class="mall-item">liptongg (shop: 1)</div>
                            <div class="mall-item">furnituredotcom (shop: 1)</div>
                            <div class="mall-item">snongline (shop: 1)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div> <!-- End team-content -->
            </div> <!-- End FAS운영2팀 -->
            
            <!-- FAS운영3팀 Section -->
            <div class="team-section team-collapsed">
                <div class="team-title" onclick="toggleTeam(this)">
                    FAS운영3팀
                    <span class="team-collapse-icon">▼</span>
                </div>
                <div class="team-content">
            
            <!-- SEOTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEOTKK - K2K SEO 전체
                    <span class="group-count">10</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG003</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG008</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG010</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG011</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG018</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG021</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG023</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG080</div>
                    </div>
                </div>
            </div>
            
            <!-- SEOTKG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEOTKG - K2G SEO 전체
                    <span class="group-count">9</span>
                    <span class="dependency-tag k2g">K2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG046</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG052</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG053</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG054</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG055</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG056</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG057</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG067</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG081</div>
                    </div>
                </div>
            </div>
            
            <!-- SEOTGG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEOTGG - G2G SEO 전체
                    <span class="group-count">6</span>
                    <span class="dependency-tag g2g">G2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG060</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG061</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG063</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG066</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG073</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG096</div>
                    </div>
                </div>
            </div>
            
            <!-- SEO1 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEO1 - K2K 상품 SEO
                    <span class="group-count">4</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG008</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG010</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG011</div>
                    </div>
                </div>
            </div>
            
            <!-- SEO2 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEO2 - K2G 상품 SEO
                    <span class="group-count">4</span>
                    <span class="dependency-tag k2g">K2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG054</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG055</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG056</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG057</div>
                    </div>
                </div>
            </div>
            
            <!-- SEO3 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEO3 - G2G 상품 SEO
                    <span class="group-count">3</span>
                    <span class="dependency-tag g2g">G2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG060</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG061</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG063</div>
                    </div>
                </div>
            </div>
            
            <!-- SEO4 Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    SEO4 - K2K 파비콘+SNS공유이미지
                    <span class="group-count">2</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG018</div>
                    </div>
                </div>
            </div>
            
            <!-- CNTTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    CNTTKK - K2K 콘텐츠 제작 전체
                    <span class="group-count">14</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA035</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA113</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA115</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA118</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA119</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA151</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA246</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA247</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA248</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA249</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA250</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA255</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA456</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA524</div>
                    </div>
                </div>
            </div>
            
            <!-- CNTTKG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    CNTTKG - K2G 콘텐츠 제작 전체
                    <span class="group-count">2</span>
                    <span class="dependency-tag k2g">K2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA773</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA774</div>
                    </div>
                </div>
            </div>
            
            <!-- CNTTGG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    CNTTGG - G2G 콘텐츠 제작 전체
                    <span class="group-count">2</span>
                    <span class="dependency-tag g2g">G2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA812</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA837</div>
                    </div>
                </div>
            </div>
            
            <!-- DESKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    DESKK - K2K 디자인 제작
                    <span class="group-count">7</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA035</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA113</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA115</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA118</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA119</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA151</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA456</div>
                    </div>
                </div>
            </div>
            
            <!-- DESKG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    DESKG - K2G 디자인 제작
                    <span class="group-count">2</span>
                    <span class="dependency-tag k2g">K2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA773</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA774</div>
                    </div>
                </div>
            </div>
            
            <!-- DESGG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    DESGG - G2G 디자인 제작
                    <span class="group-count">2</span>
                    <span class="dependency-tag g2g">G2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA812</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA837</div>
                    </div>
                </div>
            </div>
            
            <!-- MTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    MTKK - K2K 몰 구축/리뉴얼
                    <span class="group-count">3</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG020</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA036</div>
                    </div>
                </div>
            </div>
            
            <!-- MTKG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    MTKG - K2G 몰 구축/리뉴얼
                    <span class="group-count">2</span>
                    <span class="dependency-tag k2g">K2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA785</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA786</div>
                    </div>
                </div>
            </div>
            
            <!-- MTGG Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    MTGG - G2G 몰 구축/리뉴얼
                    <span class="group-count">2</span>
                    <span class="dependency-tag g2g">G2G</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA835</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA836</div>
                    </div>
                </div>
            </div>
            </div> <!-- End team-content -->
            </div> <!-- End FAS운영3팀 -->
            

            <!-- PAUSE Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    PAUSE - K2K 서비스 일시 OFF
                    <span class="group-count">59</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG004</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG006</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG007</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG008</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG010</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG018</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">EG021</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA001</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA005</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA007</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA009</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA010</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA011</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA012</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA013</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA014</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA016</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA017</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA019</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA022</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA024</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA025</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA026</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA027</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA028</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA029</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA030</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA039</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA040</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA041</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA045</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA047</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA049</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA050</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA083</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA084</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA085</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA090</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA092</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA093</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA106</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA107</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA125</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA132</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA154</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA179</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA180</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA181</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA182</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA183</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA221</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA230</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA242</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA552</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA571</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA572</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA574</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA575</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">MO010</div>
                    </div>
                    
                    <!-- PAUSE Mall Information -->
                    <div class="mall-info-section">
                        <div class="mall-info-header collapsed" onclick="toggleMallInfo(this)">
                            🏪 Mall Information <span class="mall-count">(25 shops)</span>
                            <span class="mall-collapse-icon">▼</span>
                        </div>
                        <div class="mall-list collapsed">
                            <div class="mall-item">seouli00 (shop: 1)</div>
                            <div class="mall-item">itiscoolthing (shop: 1)</div>
                            <div class="mall-item">lemetier84 (shop: 1)</div>
                            <div class="mall-item">lalahomekr (shop: 1)</div>
                            <div class="mall-item">tsuvary (shop: 1)</div>
                            <div class="mall-item">buddyboo (shop: 1, 2)</div>
                            <div class="mall-item">jungjikmall2 (shop: 1)</div>
                            <div class="mall-item">mcgun (shop: 1)</div>
                            <div class="mall-item">wnsgh13077 (shop: 1)</div>
                            <div class="mall-item">bysec2022 (shop: 7)</div>
                            <div class="mall-item">wingbling (shop: 1, 12)</div>
                            <div class="mall-item">pestoyoil (shop: 1)</div>
                            <div class="mall-item">legodtofficial (shop: 1)</div>
                            <div class="mall-item">brooksbrothers (shop: 1)</div>
                            <div class="mall-item">rockportbki (shop: 1)</div>
                            <div class="mall-item">odenserepresent (shop: 1)</div>
                            <div class="mall-item">lifeofficial (shop: 4)</div>
                            <div class="mall-item">pyrenexhome (shop: 1)</div>
                            <div class="mall-item">ppcompany1 (shop: 1)</div>
                            <div class="mall-item">xxixx0580 (shop: 1)</div>
                            <div class="mall-item">useit (shop: 1)</div>
                            <div class="mall-item">snongline (shop: 1)</div>
                            <div class="mall-item">ebur2231 (shop: 1)</div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- YTBTKK Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    YTBTKK - K2K 유튜브 특화 전체
                    <span class="group-count">11</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA080</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA081</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA097</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA098</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA150</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA151</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA152</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA153</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA154</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA196</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA208</div>
                    </div>
                    
                </div>
            </div>
            
            <!-- B2B Module -->
            <div class="main-group collapsed">
                <div class="main-group-header module-header collapsible-header" onclick="toggleCollapse(this)">
                    B2B - B2B 특화
                    <span class="group-count">3</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="collapse-icon">▼</span>
                </div>
                <div class="subgroups collapsible-content">
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA459</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA460</div>
                    </div>
                    <div class="subgroup">
                        <div class="subgroup-name work-item">FA461</div>
                    </div>
                </div>
            </div>


            <!-- Single Work Section -->
            <div class="team-section team-collapsed">
                <div class="team-title single-work-title" onclick="toggleTeam(this)">
                    Single Work
                    <span class="group-count" id="single-work-count">0</span>
                    <span class="dependency-tag">K2K</span>
                    <span class="team-collapse-icon">▼</span>
                </div>
                <div class="team-content subgroups scrollable" id="single-work-content">
                    <!-- Dynamic content will be populated here -->
                </div>
            </div> <!-- End Single Work -->
        </div>
            </div> <!-- End left-panel -->
            
            <!-- Right Panel: Search & Input -->
            <div class="right-panel">
                <h2>🔍 Search & Manage</h2>
                
                <!-- Search Section -->
                <div class="search-container">
                    <input type="text" 
                           id="mallSearch" 
                           placeholder="Search mall_id:shop_no (e.g., haveainc:1)" 
                           class="search-input">
                    <button onclick="searchMall()" class="search-button">🔍</button>
                    <div id="searchResults" class="search-results"></div>
                </div>
                
                <!-- Add New Mall Assignment -->
                <div class="management-panel">
                    <h3>✏️ Add New Mall Assignment</h3>
                    <div class="input-group">
                        <label for="taskNumber">Task Number:</label>
                        <input type="text" id="taskNumber" placeholder="e.g., TASK-2024-001" class="input-field">
                    </div>
                    <div class="input-group">
                        <label for="mallId">Mall ID:</label>
                        <input type="text" id="mallId" placeholder="e.g., haveainc" class="input-field">
                    </div>
                    <div class="input-group">
                        <label for="shopNo">Shop Number:</label>
                        <input type="text" id="shopNo" placeholder="e.g., 1" class="input-field">
                    </div>
                    <button onclick="addMallAssignment()" class="action-button add-button">Add Assignment</button>
                    <div id="addResult" class="result-message"></div>
                </div>
                
                <!-- Delete Mall Assignment -->
                <div class="management-panel">
                    <h3>🗑️ Delete Mall Assignment</h3>
                    <div class="input-group">
                        <label for="deleteTaskNumber">Task Number:</label>
                        <input type="text" id="deleteTaskNumber" placeholder="e.g., TASK-2024-001" class="input-field">
                    </div>
                    <div class="input-group">
                        <label for="deleteMallId">Mall ID:</label>
                        <input type="text" id="deleteMallId" placeholder="e.g., haveainc" class="input-field">
                    </div>
                    <div class="input-group">
                        <label for="deleteShopNo">Shop Number:</label>
                        <input type="text" id="deleteShopNo" placeholder="e.g., 1" class="input-field">
                    </div>
                    <button onclick="deleteMallAssignment()" class="action-button delete-button">Delete Assignment</button>
                    <div id="deleteResult" class="result-message"></div>
                </div>
                
            </div>
        </div> <!-- End dashboard-content -->
    </div>

    <script>
        // Engine mapping
        const engineData = {
            "EG001": true, "EG003": true, "EG004": true, "EG005": true, "EG006": true,
            "EG007": true, "EG008": true, "EG009": true, "EG010": true, "EG011": true,
            "EG015": true, "EG017": true, "EG018": true, "EG019": true, "EG020": true,
            "EG021": true,
            "EG023": true, "EG035": true, "EG046": true, "EG051": true, "EG052": true, "EG069": true,
            "EG053": true, "EG054": true, "EG055": true, "EG056": true, "EG057": true,
            "EG060": true, "EG061": true, "EG063": true, "EG066": true, "EG067": true,
            "EG073": true, "EG080": true, "EG081": true, "EG096": true, "FA001": true, "FA005": true,
            "FA007": true, "FA009": true, "FA010": true, "FA011": true, "FA012": true,
            "FA013": true, "FA014": true, "FA016": true, "FA017": true, "FA019": true,
            "FA022": true, "FA024": true, "FA025": true, "FA026": true, "FA027": true,
            "FA028": true, "FA029": true,
            "FA030": true, "FA035": false, "FA036": true, "FA039": true, "FA040": true,
            "FA041": true, "FA045": true, "FA047": true, "FA049": true, "FA050": true,
            "FA080": true, "FA081": false, "FA083": true, "FA084": true, "FA085": true,
            "FA087": false, "FA090": true, "FA092": true, "FA093": true, "FA097": true,
            "FA098": false, "FA106": true, "FA107": true, "FA113": false, "FA115": false,
            "FA118": false, "FA119": true, "FA125": true, "FA132": true, "FA150": false,
            "FA151": false, "FA152": false, "FA153": false, "FA154": true, "FA179": true,
            "FA180": true, "FA181": true, "FA182": true, "FA183": true, "FA184": false,
            "FA196": true, "FA199": true, "FA200": true,
            "FA208": true, "FA221": true, "FA230": true, "FA242": true, "FA246": false,
            "FA247": false, "FA248": false, "FA249": false, "FA250": false, "FA255": false,
            "FA456": false, "FA459": false, "FA460": false, "FA461": false, "FA524": false,
            "FA551": true, "FA552": true, "FA553": true, "FA571": true, "FA572": true,
            "FA574": true, "FA575": true, "FA773": false, "FA774": false, "FA785": false,
            "FA786": false, "FA812": false, "FA835": false, "FA836": false, "FA837": false,
            "MO010": false
        };

        // Work titles mapping
        const workTitles = {
            "EG001": "[D2C]CS_배송완료 자동체크 앱 충전관리",
            "EG003": "[디지털 경험 최적화] 게시판 SEO 기본설정",
            "EG004": "[운영 효율성 제고] 메시지 LMS 사용 기본 설정",
            "EG005": "[운영 효율성 제고] 알림톡 사용 기본 설정",
            "EG006": "[운영 효율성 제고] 배송완료 자동체크 앱 사용 설정",
            "EG007": "프로모션_회원가입 자동알림 사용설정",
            "EG008": "[D2C] 상품 SEO 설정(전체상품-초기)",
            "EG009": "상품 SEO 설정(신상품-FAS수집)",
            "EG010": "상품 SEO 설정(신상품-EC수집)",
            "EG011": "[상품 경쟁력 강화] 상품 SEO 관리 자동화",
            "EG015": "[D2C]프로모션/CRM_프로모션 제안 생성 (시스템 제안)",
            "EG017": "파비콘 설정",
            "EG018": "SNS 공유 이미지 생성",
            "EG019": "몰리뉴얼 알림 및 제안",
            "EG020": "몰리뉴얼 스킨 생성 (2)",
            "EG021": "[디지털 경험 최적화] 사이트 SEO 기본설정",
            "EG023": "쇼핑몰 속도 최적화",
            "EG035": "[디지털 경험 최적화] 랜딩페이지 A/B 테스트 설정",
            "EG046": "[글로벌] 파비콘 설정(승인+7일)",
            "EG051": "[운영 효율성 제고] 자동 주문 취소 시스템",
            "EG052": "[글로벌] 사이트 SEO 기본설정",
            "EG053": "[글로벌] 게시판 SEO 기본설정",
            "EG054": "상품 SEO 설정(전체상품-초기)",
            "EG055": "상품 SEO 설정(신상품-FAS수집)",
            "EG056": "상품 SEO 설정(신상품-EC수집)",
            "EG057": "[상품 경쟁력 강화] 상품 SEO 관리 자동화",
            "EG060": "[G2G] 카페24 PRO 신규 상품 SEO 생성 및 최적화",
            "EG061": "[G2G] 쇼핑몰 신규 상품 SEO 생성 및 최적화",
            "EG063": "[G2G] 전체 상품 SEO 생성 및 최적화",
            "EG066": "[G2G] SNS 공유 이미지 생성(승인+7일)",
            "EG067": "쇼핑몰 속도 최적화",
            "EG069": "[고객 관리 최적화] 고객 세그먼테이션 자동화",
            "EG073": "[G2G] 게시판 SEO 기본설정",
            "EG080": "구글네이버 검색엔진 설정 유도 알림",
            "EG081": "(K2G) 구글네이버 검색엔진 설정 유도 알림",
            "EG096": "[G2G] 사이트 SEO 기본설정",
            "FA001": "[4종 혜택 고도화] 회원가입 혜택 세팅",
            "FA005": "첫전환 첫구매할인쿠폰안내 친구톡(승인+7일)",
            "FA007": "재구매유도 마지막구매30일 무료배송쿠폰 친구톡(승인+7일)",
            "FA009": "[퍼널 최적화] 장바구니이탈 방지 SMS 발송(승인+7일)",
            "FA010": "[고객 유지 및 관리] 장바구니 추가 버튼 설정",
            "FA011": "[퍼널 최적화] 원터치 주문서 전환 설정",
            "FA012": "[퍼널 최적화] 쿠폰 만료 자동 알림 설정 (SMS/알림톡)",
            "FA013": "[퍼널 최적화] 장기 미접속(180일) 유저 적립금 리마인드 SMS 발송(승인+7일)",
            "FA014": "장바구니이탈 이탈3일 리마인드 친구톡(승인+7일)",
            "FA016": "[퍼널 최적화] 장기 미접속(180일) 유저 재방문 리마인드 SMS 발송(승인+7일)",
            "FA017": "[KRKR-MM-PRM-CPN-SAV-001] 생일 할인 쿠폰 발급 설정",
            "FA019": "[고객 충성도 증대] 회원 수신동의 적립금 증정 이벤트 설정",
            "FA022": "리뷰작성혜택 설정",
            "FA024": "[고객 유지 및 관리] 휴면회원 기능 해제",
            "FA025": "이탈방지 마지막로그인187일 재방문할인쿠폰 친구톡(승인+7일)",
            "FA026": "[D2C]프로모션_신상품 할인 적용 (유튜브포함)",
            "FA027": "첫전환 베스트상품안내 친구톡(승인+7일)",
            "FA028": "첫전환 조회수높은상품안내 친구톡(승인+7일)",
            "FA029": "재구매유도 마지막구매10일 재구매높은상품 친구톡(승인+7일)",
            "FA030": "재구매유도 마지막구매90일 장바구니인기상품 친구톡(승인+7일)",
            "FA035": "[D2C]콘텐츠_브랜드가치제고_메인페이지브랜드대배너제공",
            "FA036": "[D2C]구축_브랜드가치제고_쇼핑몰구축",
            "FA039": "[D2C]콘텐츠_브랜드가치제고_심미성AI진단",
            "FA040": "[D2C]SEO_최적화_사이트SEO설정(EC)",
            "FA041": "[D2C]SEO_최적화_상품SEO설정(EC)",
            "FA045": "[D2C]CS_고객관리_FAQ기본설정001(EC)",
            "FA047": "[D2C]CS_고객관리_FAQ맞춤보강001(EC)",
            "FA049": "[D2C]CS_고객관리_FAQ경로상세조정(메인노출)",
            "FA050": "[D2C]CS_이용정보제공_자동알림메세지점검및개선",
            "FA080": "[D2C]마케팅_판로확대_유튜브전용몰기본설정",
            "FA081": "[D2C]마케팅_판로확대_유튜브전용몰상품연동",
            "FA083": "[고객 가치 제공] SMS 자동 충전",
            "FA084": "[고객 가치 제공] 대량 메일 자동 충전",
            "FA085": "이탈방지 마지막로그인365일 재방문할인쿠폰 친구톡(승인+7일)",
            "FA087": "[D2C]프로모션_판매촉진_장바구니이탈고객대상할인쿠폰배너노출",
            "FA090": "[마켓]상품_기본설정_오픈마켓이미지노출관리",
            "FA092": "[서비스 접근성 강화] 카카오싱크 설정 체크",
            "FA093": "재구매유도 마지막구매180일 재구매할인쿠폰 친구톡(승인+7일)",
            "FA097": "[D2C]마케팅_트래픽확보_마케팅채널연결005-1(내부_유튜브전용몰생성)",
            "FA098": "마케팅채널연결_005-2(내부_유튜브어필리에이트서비스)",
            "FA106": "[D2C]상품_판매촉진_추가구매상품추천",
            "FA107": "[구매 전환 및 반복 구매 유도] 쿠폰 기본 설정",
            "FA113": "[D2C]콘텐츠_브랜드가치제고_상세페이지고객센터콘텐츠제공",
            "FA115": "[D2C]콘텐츠_브랜드가치제고_상세페이지브랜드컨셉콘텐츠제공",
            "FA118": "[D2C]콘텐츠_판매촉진_메인페이지신상품대배너제공",
            "FA119": "[D2C]콘텐츠_판매촉진_상품 썸네일_사이즈개선",
            "FA125": "[D2C]CS_이용정보제공_재입고알림기능제공",
            "FA132": "프로모션/CRM운영을위한설정감지및자동안내",
            "FA150": "[D2C]유튜브쇼핑전용스토어_구축_브랜드가치제고_기본정보설정",
            "FA151": "[D2C]유튜브쇼핑전용스토어_콘텐츠_최적화_상세페이지상품정보콘텐츠제공",
            "FA152": "[D2C]유튜브쇼핑전용스토어_상품_판매촉진_신규상품등록",
            "FA153": "[D2C]유튜브쇼핑전용스토어_상품_판매촉진_상품정보수정",
            "FA154": "[D2C]유튜브쇼핑전용스토어_프로모션_판매촉진_신상품할인이벤트실행",
            "FA179": "[D2C]v2_빠른 결제 사용",
            "FA180": "[D2C]v2_취소/교환/반품 접수 응답 자동화",
            "FA181": "[D2C]v2_취소/교환/반품 정보 리포팅",
            "FA182": "[D2C]v2_취소/교환/반품 CRM메시지 기본 설정",
            "FA183": "[D2C] 메인페이지 진열 관리",
            "FA184": "[D2C]프로모션_판매촉진_동일상품조회고객대상할인쿠폰배너노출",
            "FA185": "[마켓]상품_기본설정_상품등록_스마트스토어",
            "FA186": "[마켓]상품_기본설정_상품등록_쿠팡",
            "FA187": "[마켓]상품_기본설정_상품등록_G마켓",
            "FA188": "[마켓]상품_기본설정_상품등록_옥션",
            "FA189": "[공통]온보딩_필수_대표이메일 및 대표인증번호 설정",
            "FA190": "[공통]온보딩_필수_통합결제(PG) 신청 및 설정",
            "FA191": "[공통]온보딩_기본_도메인 구매/이전 및 설정",
            "FA192": "[공통]온보딩_기본_내 쇼핑몰 정보 설정",
            "FA193": "[공통]온보딩_기본_이용안내 설정",
            "FA194": "[공통]온보딩_기본_이용약관 및 개인정보 처리방침 설정",
            "FA195": "[공통]온보딩_기본_주문 및 배송 설정",
            "FA196": "[공통]온보딩_기본 _유튜브쇼핑 및 채널 설정",
            "FA197": "[공통]온보딩_운영 _마켓 부계정 생성",
            "FA198": "[공통]온보딩_운영_SMS 발신번호 설정",
            "FA199": "[공통]온보딩_운영_카카오 알림톡/친구톡 설정",
            "FA200": "[공통]온보딩_운영_카카오 친구톡 캠페인 설정",
            "FA201": "[공통]온보딩_운영_카카오톡 비즈니스 채널 생성 및 설정",
            "FA202": "[공통]온보딩_운영_080 무료수신거부 신청 및 전화번호 등록",
            "FA203": "[D2C]공통_글로벌진출체력진단_기본_001",
            "FA204": "[D2C]콘텐츠_사이트최적화_사이트속도점검 및 개선",
            "FA205": "[D2C]풀오토_플랫폼내제화_TASK_sample",
            "FA206": "[공통]온보딩_기본 _플러스앱 설정 가이드",
            "FA207": "[마켓]상품_기본설정_상품등록_11번가",
            "FA208": "[공통]환경세팅_몰분석_유튜브세팅여부판별_001",
            "FA209": "[공통]환경점검_도메인만료_리마인드",
            "FA210": "[공통]환경점검_신규서비스출시_대상군선별_신청유도_리마인드",
            "FA211": "[D2C]v3_경쟁사 벤치마크 분석을 통한 매출 최적화 전략 도출",
            "FA212": "[공통]환경점검_대상군선별(매출0)_행동개선구간푸쉬형알림_리마인드",
            "FA213": "[D2C]프로모션/CRM_프로모션캘린더 이벤트일정설정",
            "FA214": "[D2C]프로모션_판매촉진_기념일형_화이트데이",
            "FA215": "[D2C]프로모션_판매촉진_시즌형_여름맞이(6월)",
            "FA216": "[D2C]프로모션_판매촉진_시즌형_겨울맞이(11월)",
            "FA217": "[D2C]프로모션_판매촉진_기념일형_가정의 달",
            "FA218": "[D2C]프로모션_판매촉진_기념일형_추석(9월)",
            "FA219": "[D2C]프로모션_판매촉진_트렌드형_여름방학(7월)",
            "FA220": "[D2C]프로모션_판매촉진_시즌형_여름 시즌오프(8월)",
            "FA221": "[고객 충성도 증대] 리뷰작성유도 설정(SMS)",
            "FA229": "[D2C]콘텐츠_판매촉진_프로모션배너제공",
            "FA230": "[D2C]CS_환경세팅_비사용 게시판 정리",
            "FA242": "[D2C]상품_ 최적화_인기상품 분류 자동 관리",
            "FA245": "[D2C]프로모션_판매촉진_이벤트접수기반 실행_A타입(기간/내용/할인/혜택)",
            "FA246": "[D2C]콘텐츠_사이트최적화_UI진단및개선_메인페이지",
            "FA247": "[D2C]콘텐츠_사이트최적화_UI진단및개선_상품분류페이지",
            "FA248": "[D2C]콘텐츠_사이트최적화_UI진단및개선_상품상세페이지",
            "FA249": "[D2C]콘텐츠_사이트최적화_UI진단및개선_장바구니",
            "FA250": "[D2C]콘텐츠_사이트최적화_UI진단및개선_로그인",
            "FA251": "[공통]운영지원_비대면접수_부가정보_상시이벤트접수(커스텀1)_정보전달",
            "FA252": "[상품 경쟁력 강화] 고객 기반_자주묻는질문 콘텐츠 등록",
            "FA253": "[상품 경쟁력 강화] 고객 기반_리뷰 콘텐츠 등록",
            "FA254": "[상품 경쟁력 강화] 고객 기반_주문자 정보 콘텐츠 등록",
            "FA255": "[D2C]콘텐츠_사이트최적화_UI진단및개선_검색페이지",
            "FA455": "[D2C]콘텐츠_동영상제작지원_AI템플릿활용",
            "FA456": "[D2C]콘텐츠_동영상제작지원_SNS및외부배너표준사이즈제작및제공",
            "FA458": "[브랜드]_[D2C]브랜드 스토리 생성 및 페이지 구축",
            "FA459": "[B2B]브랜드 스토리 생성 및 페이지 구축",
            "FA460": "[B2B] 브랜드 스토리 생성 및 페이지 구축_프랜차이즈 성공사례",
            "FA461": "[B2B]UX_거래가이드_페이지제작",
            "FA510": "[D2C]프로모션_판매촉진_창립기념 이벤트",
            "FA511": "[D2C]프로모션_판매촉진_회원 수 달성 이벤트",
            "FA512": "[D2C]프로모션_판매촉진_자유주제 이벤트",
            "FA524": "[D2C]콘텐츠_사이트최적화_UI진단및개선_회원가입페이지",
            "FA550": "[상품 경쟁력 강화] 고객 기반_상품 정보 보강 콘텐츠 등록",
            "FA551": "(알파푸시) 첫 방문 고객 대상 인기 상품 추천 캠페인 (승인+7일)",
            "FA552": "[D2C]프로모션_고민 중인 고객 대상 인기 상품 추천 캠페인",
            "FA553": "(알파푸시) 회원가입 완료 대상 인기 상품 추천 캠페인 (승인+7일)",
            "FA570": "몰리뉴얼 알림 및 제안",
            "FA571": "[상품 경쟁력 강화] 쇼핑몰 신규 상품 SEO 생성 및 최적화",
            "FA572": "[상품 경쟁력 강화] 카페24 PRO 신규 상품 SEO 생성 및 최적화",
            "FA573": "[디지털 경험 최적화] 게시판 SEO 기본설정",
            "FA574": "SNS 공유 이미지 생성",
            "FA575": "파비콘 설정",
            "FA580": "[FAS운영1팀]서비스 표준 모니터링",
            "FA581": "[FAS운영1팀]서비스 개선/고도화(PDCA)_핵심지표데이터기반",
            "FA582": "[FAS운영1팀]서비스 개선/고도화(PDCA)_실패데이터기반",
            "FA583": "[FAS운영1팀]서비스 CS인입데이터 기반 처리/답변",
            "FA584": "[FAS운영2팀] 서비스 표준 모니터링",
            "FA585": "[FAS운영2팀] 서비스 개선/고도화(PDCA)_핵심지표데이터기반",
            "FA586": "[FAS운영2팀] 서비스 개선/고도화(PDCA)_실패데이터기반",
            "FA587": "[FAS운영2팀] 서비스 CS인입데이터 기반 처리/답변",
            "FA592": "[FAS운영3팀] 서비스 표준 모니터링",
            "FA593": "[FAS운영3팀] 서비스 개선/고도화(PDCA)_핵심지표데이터기반",
            "FA594": "[FAS운영3팀] 서비스 개선/고도화(PDCA)_실패데이터기반",
            "FA595": "[FAS운영3팀] 서비스 CS인입데이터 기반 처리/답변",
            "FA773": "[K2G]영문몰 배너 제작",
            "FA774": "[K2G]일문몰 배너 제작",
            "FA785": "[K2G]영문몰 스킨 제작",
            "FA786": "[K2G]일문몰 스킨 제작",
            "FA812": "[G2G]영문몰 배너 제작",
            "FA835": "[G2G]영문몰 스킨 제작",
            "FA836": "[G2G]일문몰 스킨 제작",
            "FA837": "[G2G]일문몰 배너 제작",
            "MO010": "[모니터링 자동화]고객관리_FAQ기본설정001(EC)",
            "FA009": "[퍼널 최적화] 장바구니이탈 방지 SMS 발송(승인+7일)",
            "FA012": "[퍼널 최적화] 쿠폰 만료 자동 알림 설정",
            "FA013": "[퍼널 최적화] 장기 미접속(180일) 유저 적립금 리마인드 SMS 발송(승인+7일)",
            "FA016": "[퍼널 최적화] 장기 미접속(180일) 유저 재방문 리마인드 SMS 발송(승인+7일)",
            "FA221": "[고객 충성도 증대] 리뷰작성유도 설정(승인+7일)",
            "FA005": "첫전환 첫구매할인쿠폰안내 친구톡(승인+7일)",
            "FA007": "재구매유도 마지막구매30일 무료배송쿠폰 친구톡(승인+7일)",
            "FA014": "장바구니이탈 이탈3일 리마인드 친구톡(승인+7일)",
            "FA025": "이탈방지 마지막로그인187일 재방문할인쿠폰 친구톡(승인+7일)",
            "FA027": "첫전환 베스트상품안내 친구톡(승인+7일)",
            "FA028": "첫전환 조회수높은상품안내 친구톡(승인+7일)",
            "FA029": "재구매유도 마지막구매10일 재구매높은상품 친구톡(승인+7일)",
            "FA030": "재구매유도 마지막구매90일 장바구니인기상품 친구톡(승인+7일)",
            "FA085": "이탈방지 마지막로그인365일 재방문할인쿠폰 친구톡(승인+7일)",
            "FA093": "재구매유도 마지막구매180일 재구매할인쿠폰 친구톡(승인+7일)",
            "FA024": "[고객 유지 및 관리] 휴면회원 기능 해제",
            "FA010": "[고객 유지 및 관리] 장바구니 추가 버튼 설정",
            "FA092": "[서비스 접근성 강화] 카카오싱크 설정 체크",
            "FA200": "[서비스 접근성 강화] 카카오친구톡 캠페인 설정 체크",
            "FA199": "[서비스 접근성 강화] 카카오 알림톡/친구톡 기본 설정 체크",
            "FA107": "[구매 전환 및 반복 구매 유도] 쿠폰 기본 설정",
            "EG004": "[운영 효율성 제고] 메시지 LMS 사용 기본 설정",
            "FA196": "[공통]온보딩_기본 _유튜브쇼핑 및 채널 설정",
            "FA080": "[D2C]마케팅_판로확대_유튜브전용몰기본설정",
            "FA081": "[D2C]마케팅_판로확대_유튜브전용몰상품연동",
            "FA097": "[D2C]마케팅_트래픽확보_마케팅채널연결005-1(내부_유튜브전용몰생성)",
            "FA098": "마케팅채널연결_005-2(내부_유튜브어필리에이트서비스)",
            "FA150": "[D2C]유튜브쇼핑전용스토어_구축_브랜드가치제고_기본정보설정",
            "FA151": "[D2C]유튜브쇼핑전용스토어_콘텐츠_최적화_상세페이지상품정보콘텐츠제공",
            "FA152": "[D2C]유튜브쇼핑전용스토어_상품_판매촉진_신규상품등록",
            "FA153": "[D2C]유튜브쇼핑전용스토어_상품_판매촉진_상품정보수정",
            "FA154": "[D2C]유튜브쇼핑전용스토어_프로모션_판매촉진_신상품할인이벤트실행",
            "FA208": "[공통]환경세팅_몰분석_유튜브세팅여부판별_001",
            "FA459": "[B2B]브랜드 스토리 생성 및 페이지 구축",
            "FA460": "[B2B] 브랜드 스토리 생성 및 페이지 구축_프랜차이즈 성공사례",
            "FA461": "[B2B]UX_거래가이드_페이지제작",
            "EG003": "[디지털 경험 최적화] 게시판 SEO 기본설정",
            "EG008": "[D2C] 상품 SEO 설정(전체상품-초기)",
            "EG009": "상품 SEO 설정(신상품-FAS수집)",
            "EG010": "상품 SEO 설정(신상품-EC수집)",
            "EG011": "[상품 경쟁력 강화] 상품 SEO 관리 자동화",
            "EG017": "파비콘 설정",
            "EG018": "SNS 공유 이미지 생성",
            "EG021": "[디지털 경험 최적화] 사이트 SEO 기본설정",
            "EG023": "쇼핑몰 속도 최적화",
            "EG080": "구글네이버 검색엔진 설정 유도 알림",
            "EG046": "[글로벌] 파비콘 설정(승인+7일)",
            "EG052": "[글로벌] 사이트 SEO 기본설정",
            "EG053": "[글로벌] 게시판 SEO 기본설정",
            "EG054": "상품 SEO 설정(전체상품-초기)",
            "EG055": "상품 SEO 설정(신상품-FAS수집)",
            "EG056": "상품 SEO 설정(신상품-EC수집)",
            "EG057": "[상품 경쟁력 강화] 상품 SEO 관리 자동화",
            "EG067": "쇼핑몰 속도 최적화",
            "EG081": "(K2G) 구글네이버 검색엔진 설정 유도 알림",
            "EG060": "[G2G] 카페24 PRO 신규 상품 SEO 생성 및 최적화",
            "EG061": "[G2G] 쇼핑몰 신규 상품 SEO 생성 및 최적화",
            "EG063": "[G2G] 전체 상품 SEO 생성 및 최적화",
            "EG066": "[G2G] SNS 공유 이미지 생성(승인+7일)",
            "EG073": "[G2G] 게시판 SEO 기본설정",
            "EG096": "[G2G] 사이트 SEO 기본설정",
            "FA035": "[D2C]콘텐츠_브랜드가치제고_메인페이지브랜드대배너제공",
            "FA113": "[D2C]콘텐츠_브랜드가치제고_상세페이지고객센터콘텐츠제공",
            "FA115": "[D2C]콘텐츠_브랜드가치제고_상세페이지브랜드컨셉콘텐츠제공",
            "FA118": "[D2C]콘텐츠_판매촉진_메인페이지신상품대배너제공",
            "FA119": "[D2C]콘텐츠_판매촉진_상품 썸네일_사이즈개선",
            "FA246": "[D2C]콘텐츠_사이트최적화_UI진단및개선_메인페이지",
            "FA247": "[D2C]콘텐츠_사이트최적화_UI진단및개선_상품분류페이지",
            "FA248": "[D2C]콘텐츠_사이트최적화_UI진단및개선_상품상세페이지",
            "FA249": "[D2C]콘텐츠_사이트최적화_UI진단및개선_장바구니",
            "FA250": "[D2C]콘텐츠_사이트최적화_UI진단및개선_로그인",
            "FA251": "[공통]운영지원_비대면접수_부가정보_상시이벤트접수(커스텀1)_정보전달",
            "FA252": "[상품 경쟁력 강화] 고객 기반_자주묻는질문 콘텐츠 등록",
            "FA253": "[상품 경쟁력 강화] 고객 기반_리뷰 콘텐츠 등록",
            "FA254": "[상품 경쟁력 강화] 고객 기반_주문자 정보 콘텐츠 등록",
            "FA255": "[D2C]콘텐츠_사이트최적화_UI진단및개선_검색페이지",
            "FA524": "[D2C]콘텐츠_사이트최적화_UI진단및개선_회원가입페이지",
            "FA456": "[D2C]콘텐츠_동영상제작지원_SNS및외부배너표준사이즈제작및제공",
            "FA773": "[K2G]영문몰 배너 제작",
            "FA774": "[K2G]일문몰 배너 제작",
            "FA812": "[G2G]영문몰 배너 제작",
            "FA837": "[G2G]일문몰 배너 제작",
            "EG019": "몰리뉴얼 알림 및 제안",
            "EG020": "몰리뉴얼 스킨 생성 (2)",
            "FA036": "[D2C]구축_브랜드가치제고_쇼핑몰구축",
            "FA785": "[K2G]영문몰 스킨 제작",
            "FA786": "[K2G]일문몰 스킨 제작",
            "FA835": "[G2G]영문몰 스킨 제작",
            "FA836": "[G2G]일문몰 스킨 제작",
            "FA837": "[G2G]콘텐츠_기본제공_일문상품상세이미지콘텐츠제공",
            "MO010": "모바일앱_iOS 브랜딩 설정",
            "FA256": "[공통]콘텐츠_기본제공_상품리스트형상품이미지콘텐츠제공",
            "FA257": "[공통]콘텐츠_기본제공_모바일앱화면상품이미지콘텐츠제공",
            "FA258": "[공통]콘텐츠_기본제공_알림톡이미지콘텐츠제공",
            "FA259": "[공통]콘텐츠_기본제공_친구톡이미지콘텐츠제공",
            "FA260": "[공통]콘텐츠_기본제공_SMS이미지콘텐츠제공",
            "FA261": "[공통]콘텐츠_기본제공_이메일이미지콘텐츠제공",
            "FA262": "[공통]콘텐츠_기본제공_소셜이미지콘텐츠제공",
            "FA263": "[공통]콘텐츠_기본제공_유튜브쇼츠이미지콘텐츠제공",
            "FA264": "[공통]콘텐츠_기본제공_유튜브동영상이미지콘텐츠제공",
            "FA265": "[공통]콘텐츠_기본제공_인스타그램피드이미지콘텐츠제공",
            "FA266": "[공통]콘텐츠_기본제공_인스타그램스토리이미지콘텐츠제공",
            "FA267": "[공통]콘텐츠_기본제공_페이스북피드이미지콘텐츠제공",
            "FA268": "[공통]콘텐츠_기본제공_페이스북스토리이미지콘텐츠제공",
            "FA269": "[공통]콘텐츠_기본제공_틱톡이미지콘텐츠제공",
            "FA270": "[공통]콘텐츠_기본제공_네이버포스트이미지콘텐츠제공",
            "FA271": "[공통]콘텐츠_기본제공_네이버블로그이미지콘텐츠제공",
            "FA272": "[공통]콘텐츠_기본제공_카카오스토리이미지콘텐츠제공",
            "FA273": "[공통]콘텐츠_기본제공_카카오톡이미지콘텐츠제공",
            "FA274": "[공통]콘텐츠_기본제공_라인이미지콘텐츠제공",
            "FA275": "[공통]콘텐츠_기본제공_텔레그램이미지콘텐츠제공",
            "FA276": "[공통]콘텐츠_기본제공_위챗이미지콘텐츠제공",
            "FA277": "[공통]콘텐츠_기본제공_왓츠앱이미지콘텐츠제공",
            "FA278": "[공통]콘텐츠_기본제공_기타이미지콘텐츠제공",
            "FA279": "[공통]콘텐츠_기본제공_A4전단지이미지콘텐츠제공",
            "FA280": "[공통]콘텐츠_기본제공_A3포스터이미지콘텐츠제공",
            "FA281": "[공통]콘텐츠_기본제공_A2포스터이미지콘텐츠제공",
            "FA282": "[공통]콘텐츠_기본제공_A1포스터이미지콘텐츠제공",
            "FA283": "[공통]콘텐츠_기본제공_A0포스터이미지콘텐츠제공",
            "FA284": "[공통]콘텐츠_기본제공_배너이미지콘텐츠제공",
            "FA285": "[공통]콘텐츠_기본제공_현수막이미지콘텐츠제공",
            "FA286": "[공통]콘텐츠_기본제공_X배너이미지콘텐츠제공",
            "FA287": "[공통]콘텐츠_기본제공_롤배너이미지콘텐츠제공",
            "FA288": "[공통]콘텐츠_기본제공_POP이미지콘텐츠제공",
            "FA289": "[공통]콘텐츠_기본제공_스티커이미지콘텐츠제공",
            "FA290": "[공통]콘텐츠_기본제공_명함이미지콘텐츠제공",
            "FA291": "[공통]콘텐츠_기본제공_카드뉴스이미지콘텐츠제공",
            "FA292": "[공통]콘텐츠_기본제공_인포그래픽이미지콘텐츠제공",
            "FA293": "[공통]콘텐츠_기본제공_썸네일이미지콘텐츠제공",
            "FA294": "[공통]콘텐츠_기본제공_로고이미지콘텐츠제공",
            "FA295": "[공통]콘텐츠_기본제공_아이콘이미지콘텐츠제공",
            "FA296": "[공통]콘텐츠_기본제공_일러스트이미지콘텐츠제공",
            "FA297": "[공통]콘텐츠_기본제공_캐릭터이미지콘텐츠제공",
            "FA298": "[공통]콘텐츠_기본제공_패턴이미지콘텐츠제공",
            "FA299": "[공통]콘텐츠_기본제공_텍스처이미지콘텐츠제공",
            "FA300": "[공통]콘텐츠_기본제공_배경이미지콘텐츠제공",
            "FA301": "[공통]콘텐츠_기본제공_프레임이미지콘텐츠제공",
            "FA302": "[공통]콘텐츠_기본제공_테두리이미지콘텐츠제공",
            "FA303": "[공통]콘텐츠_기본제공_워터마크이미지콘텐츠제공",
            "FA304": "[공통]콘텐츠_기본제공_효과이미지콘텐츠제공",
            "FA305": "[공통]콘텐츠_기본제공_필터이미지콘텐츠제공",
            "FA306": "[공통]콘텐츠_기본제공_마스크이미지콘텐츠제공",
            "FA307": "[공통]콘텐츠_기본제공_클리핑패스이미지콘텐츠제공",
            "FA308": "[공통]콘텐츠_기본제공_합성이미지콘텐츠제공",
            "FA309": "[공통]콘텐츠_기본제공_편집이미지콘텐츠제공",
            "FA310": "[공통]콘텐츠_기본제공_보정이미지콘텐츠제공",
            "FA311": "[공통]콘텐츠_기본제공_리터칭이미지콘텐츠제공",
            "FA312": "[공통]콘텐츠_기본제공_색보정이미지콘텐츠제공",
            "FA313": "[공통]콘텐츠_기본제공_크롭이미지콘텐츠제공",
            "FA314": "[공통]콘텐츠_기본제공_리사이즈이미지콘텐츠제공",
            "FA315": "[공통]콘텐츠_기본제공_회전이미지콘텐츠제공",
            "FA316": "[공통]콘텐츠_기본제공_반전이미지콘텐츠제공",
            "FA317": "[공통]콘텐츠_기본제공_미러이미지콘텐츠제공",
            "FA318": "[공통]콘텐츠_기본제공_스케일이미지콘텐츠제공",
            "FA319": "[공통]콘텐츠_기본제공_왜곡이미지콘텐츠제공",
            "FA320": "[공통]콘텐츠_기본제공_변형이미지콘텐츠제공",
            "FA321": "[공통]콘텐츠_기본제공_애니메이션이미지콘텐츠제공",
            "FA322": "[공통]콘텐츠_기본제공_GIF이미지콘텐츠제공",
            "FA323": "[공통]콘텐츠_기본제공_동영상이미지콘텐츠제공",
            "FA324": "[공통]콘텐츠_기본제공_오디오이미지콘텐츠제공",
            "FA325": "[공통]콘텐츠_기본제공_음성이미지콘텐츠제공",
            "FA326": "[공통]콘텐츠_기본제공_효과음이미지콘텐츠제공",
            "FA327": "[공통]콘텐츠_기본제공_배경음이미지콘텐츠제공",
            "FA328": "[공통]콘텐츠_기본제공_테마음이미지콘텐츠제공",
            "FA329": "[공통]콘텐츠_기본제공_자막이미지콘텐츠제공",
            "FA330": "[공통]콘텐츠_기본제공_캡션이미지콘텐츠제공",
            "FA331": "[공통]콘텐츠_기본제공_타이틀이미지콘텐츠제공",
            "FA332": "[공통]콘텐츠_기본제공_헤드라인이미지콘텐츠제공",
            "FA333": "[공통]콘텐츠_기본제공_슬로건이미지콘텐츠제공",
            "FA334": "[공통]콘텐츠_기본제공_카피이미지콘텐츠제공",
            "FA335": "[공통]콘텐츠_기본제공_문구이미지콘텐츠제공",
            "FA336": "[공통]콘텐츠_기본제공_텍스트이미지콘텐츠제공",
            "FA337": "[공통]콘텐츠_기본제공_폰트이미지콘텐츠제공",
            "FA338": "[공통]콘텐츠_기본제공_타이포그래피이미지콘텐츠제공",
            "FA339": "[공통]콘텐츠_기본제공_레터링이미지콘텐츠제공",
            "FA340": "[공통]콘텐츠_기본제공_칼리그래피이미지콘텐츠제공",
            "FA341": "[공통]콘텐츠_기본제공_손글씨이미지콘텐츠제공",
            "FA342": "[공통]콘텐츠_기본제공_필기체이미지콘텐츠제공",
            "FA343": "[공통]콘텐츠_기본제공_인쇄체이미지콘텐츠제공",
            "FA344": "[공통]콘텐츠_기본제공_고딕체이미지콘텐츠제공",
            "FA345": "[공통]콘텐츠_기본제공_명조체이미지콘텐츠제공",
            "FA346": "[공통]콘텐츠_기본제공_돋움체이미지콘텐츠제공",
            "FA347": "[공통]콘텐츠_기본제공_궁서체이미지콘텐츠제공",
            "FA348": "[공통]콘텐츠_기본제공_바탕체이미지콘텐츠제공",
            "FA349": "[공통]콘텐츠_기본제공_새굴림체이미지콘텐츠제공",
            "FA350": "[공통]콘텐츠_기본제공_맑은고딕체이미지콘텐츠제공",
            "FA351": "[공통]콘텐츠_기본제공_나눔고딕체이미지콘텐츠제공",
            "FA352": "[공통]콘텐츠_기본제공_나눔명조체이미지콘텐츠제공",
            "FA353": "[공통]콘텐츠_기본제공_나눔바른고딕체이미지콘텐츠제공",
            "FA354": "[공통]콘텐츠_기본제공_나눔바른펜체이미지콘텐츠제공",
            "FA355": "[공통]콘텐츠_기본제공_나눔손글씨체이미지콘텐츠제공",
            "FA356": "[공통]콘텐츠_기본제공_한나체이미지콘텐츠제공",
            "FA357": "[공통]콘텐츠_기본제공_카페24체이미지콘텐츠제공",
            "FA358": "[공통]콘텐츠_기본제공_스포카한산스체이미지콘텐츠제공",
            "FA359": "[공통]콘텐츠_기본제공_본고딕체이미지콘텐츠제공",
            "FA360": "[공통]콘텐츠_기본제공_노토산스체이미지콘텐츠제공",
            "FA361": "[공통]콘텐츠_기본제공_로봇체이미지콘텐츠제공",
            "FA362": "[공통]콘텐츠_기본제공_오픈산스체이미지콘텐츠제공",
            "FA363": "[공통]콘텐츠_기본제공_라토체이미지콘텐츠제공",
            "FA364": "[공통]콘텐츠_기본제공_몬세라트체이미지콘텐츠제공",
            "FA365": "[공통]콘텐츠_기본제공_플레이페어체이미지콘텐츠제공",
            "FA366": "[공통]콘텐츠_기본제공_소스세리프체이미지콘텐츠제공",
            "FA367": "[공통]콘텐츠_기본제공_머리맨체이미지콘텐츠제공",
            "FA368": "[공통]콘텐츠_기본제공_옵튜니티체이미지콘텐츠제공",
            "FA369": "[공통]콘텐츠_기본제공_PT세리프체이미지콘텐츠제공",
            "FA370": "[공통]콘텐츠_기본제공_드로이드세리프체이미지콘텐츠제공",
            "FA371": "[공통]콘텐츠_기본제공_크림슨텍스트체이미지콘텐츠제공",
            "FA372": "[공통]콘텐츠_기본제공_젠티움체이미지콘텐츠제공",
            "FA373": "[공통]콘텐츠_기본제공_리버티누스체이미지콘텐츠제공",
            "FA374": "[공통]콘텐츠_기본제공_아레임체이미지콘텐츠제공",
            "FA375": "[공통]콘텐츠_기본제공_포킹체이미지콘텐츠제공",
            "FA376": "[공통]콘텐츠_기본제공_아베리아체이미지콘텐츠제공",
            "FA377": "[공통]콘텐츠_기본제공_카르마체이미지콘텐츠제공",
            "FA378": "[공통]콘텐츠_기본제공_코랄체이미지콘텐츠제공",
            "FA379": "[공통]콘텐츠_기본제공_댄싱스크립트체이미지콘텐츠제공",
            "FA380": "[공통]콘텐츠_기본제공_그레이트비베스체이미지콘텐츠제공",
            "FA381": "[공통]콘텐츠_기본제공_인디플라워체이미지콘텐츠제공",
            "FA382": "[공통]콘텐츠_기본제공_키위마루체이미지콘텐츠제공",
            "FA383": "[공통]콘텐츠_기본제공_로발스터체이미지콘텐츠제공",
            "FA384": "[공통]콘텐츠_기본제공_패시픽오체이미지콘텐츠제공",
            "FA385": "[공통]콘텐츠_기본제공_팰러타이노체이미지콘텐츠제공",
            "FA386": "[공통]콘텐츠_기본제공_사크라멘토체이미지콘텐츠제공",
            "FA387": "[공통]콘텐츠_기본제공_쉐도우인투라이트체이미지콘텐츠제공",
            "FA388": "[공통]콘텐츠_기본제공_신시아체이미지콘텐츠제공",
            "FA389": "[공통]콘텐츠_기본제공_탄제린체이미지콘텐츠제공",
            "FA390": "[공통]콘텐츠_기본제공_옐로우테일체이미지콘텐츠제공",
            "FA391": "[공통]콘텐츠_기본제공_기타폰트이미지콘텐츠제공",
            "FA392": "[공통]콘텐츠_기본제공_커스텀폰트이미지콘텐츠제공",
            "FA393": "[공통]콘텐츠_기본제공_웹폰트이미지콘텐츠제공",
            "FA394": "[공통]콘텐츠_기본제공_시스템폰트이미지콘텐츠제공",
            "FA395": "[공통]콘텐츠_기본제공_디바이스폰트이미지콘텐츠제공",
            "FA396": "[공통]콘텐츠_기본제공_OS폰트이미지콘텐츠제공",
            "FA397": "[공통]콘텐츠_기본제공_브라우저폰트이미지콘텐츠제공",
            "FA398": "[공통]콘텐츠_기본제공_앱폰트이미지콘텐츠제공",
            "FA399": "[공통]콘텐츠_기본제공_게임폰트이미지콘텐츠제공",
            "FA400": "[공통]콘텐츠_기본제공_소셜폰트이미지콘텐츠제공",
            "FA459": "[공통]콘텐츠_기본제공_상품카테고리별이미지콘텐츠제공",
            "FA460": "[공통]콘텐츠_기본제공_상품브랜드별이미지콘텐츠제공",
            "FA461": "[공통]콘텐츠_기본제공_상품시즌별이미지콘텐츠제공",
            "FA551": "[공통]검증_기본진행_고객정보안전관리검증",
            "FA552": "[공통]검증_기본진행_개인정보처리방침검증",
            "FA553": "[공통]검증_기본진행_이용약관검증",
            "FA571": "[공통]모니터링_기본진행_서비스접근성모니터링",
            "FA572": "[공통]모니터링_기본진행_서비스성능모니터링",
            "FA574": "[공통]모니터링_기본진행_보안취약점모니터링",
            "FA575": "[공통]모니터링_기본진행_법적컴플라이언스모니터링",
            "FA773": "[K2G]콘텐츠_기본제공_영문상품상세이미지콘텐츠제공",
            "FA774": "[K2G]콘텐츠_기본제공_일문상품상세이미지콘텐츠제공",
            "FA812": "[G2G]콘텐츠_기본제공_영문상품상세이미지콘텐츠제공"
        };

        // Group data structure
        const groupData = {
            acting: {
                "PRO K2K": [
                    "PRO 유튜브",
                    "PRO B2B", 
                    "PRO K2K SEO ONLY"
                ],
                "PRO K2G": [
                    "PRO K2G EN",
                    "PRO K2G JP"
                ],
                "PRO G2G": [
                    "PRO G2G EN",
                    "PRO G2G JP"
                ]
            },
            inactive: {
                "기본혜택": {
                    works: ["FA001", "FA017", "FA019", "FA022"],
                    dependency: "K2K"
                },
                "온사이트캠페인": {
                    works: ["FA551", "FA552", "FA553", "FA087", "FA184"],
                    dependency: "K2K"
                },
                "SMS 발송 캠페인": {
                    works: ["FA009", "FA012", "FA013", "FA016", "FA221"],
                    dependency: "K2K"
                },
                "친구톡 캠페인": {
                    works: ["FA005", "FA007", "FA014", "FA025", "FA027", "FA028", "FA029", "FA030", "FA085", "FA093"],
                    dependency: "K2K"
                },
                "기본혜택 + 온사이트캠페인": {
                    works: ["FA001", "FA017", "FA019", "FA022", "FA551", "FA552", "FA553", "FA087", "FA184"],
                    dependency: "K2K"
                },
                "쿠폰/적립금 (기본혜택 + 친구톡 캠페인(5개))": {
                    works: ["FA001", "FA017", "FA019", "FA022", "FA005", "FA007", "FA025", "FA085", "FA093"],
                    dependency: "K2K"
                },
                "K2K 프로모션/CRM 전체": {
                    works: ["FA001", "FA017", "FA019", "FA022", "FA551", "FA552", "FA553", "FA087", "FA184", "FA005", "FA007", "FA014", "FA025", "FA027", "FA028", "FA029", "FA030", "FA085", "FA093", "FA013", "FA016", "FA009", "FA221", "FA012", "FA024", "FA010", "FA092", "FA200", "FA199", "FA107", "EG004"],
                    dependency: "K2K"
                },
                "K2K 유튜브 특화 전체": {
                    works: ["FA196", "FA080", "FA081", "FA097", "FA098", "FA150", "FA151", "FA152", "FA153", "FA154", "FA208"],
                    dependency: "K2K"
                },
                "B2B 특화": {
                    works: ["FA459", "FA460", "FA461"],
                    dependency: "K2K"
                },
                "K2K SEO 전체": {
                    works: ["EG003", "EG008", "EG009", "EG010", "EG011", "EG017", "EG018", "EG021", "EG023", "EG080"],
                    dependency: "K2K"
                },
                "K2G SEO 전체": {
                    works: ["EG046", "EG052", "EG053", "EG054", "EG055", "EG056", "EG057", "EG067", "EG081"],
                    dependency: "K2G"
                },
                "G2G SEO 전체": {
                    works: ["EG060", "EG061", "EG063", "EG066", "EG073", "EG096"],
                    dependency: "G2G"
                },
                "K2K 상품 SEO": {
                    works: ["EG008", "EG009", "EG010", "EG011"],
                    dependency: "K2K"
                },
                "K2G 상품 SEO": {
                    works: ["EG054", "EG055", "EG056", "EG057"],
                    dependency: "K2G"
                },
                "G2G 상품 SEO": {
                    works: ["EG060", "EG061", "EG063"],
                    dependency: "G2G"
                },
                "K2K 파비콘+SNS공유이미지": {
                    works: ["EG017", "EG018"],
                    dependency: "K2K"
                },
                "K2K 콘텐츠 제작 전체": {
                    works: ["FA035", "FA113", "FA115", "FA118", "FA119", "FA151", "FA246", "FA247", "FA248", "FA249", "FA250", "FA255", "FA524", "FA456"],
                    dependency: "K2K"
                },
                "K2G 콘텐츠 제작 전체": {
                    works: ["FA773", "FA774"],
                    dependency: "K2G"
                },
                "G2G 콘텐츠 제작 전체": {
                    works: ["FA812", "FA837"],
                    dependency: "G2G"
                },
                "K2K 디자인 제작": {
                    works: ["FA035", "FA113", "FA115", "FA118", "FA119", "FA151", "FA456"],
                    dependency: "K2K"
                },
                "K2G 디자인 제작": {
                    works: ["FA773", "FA774"],
                    dependency: "K2G"
                },
                "G2G 디자인 제작": {
                    works: ["FA812", "FA837"],
                    dependency: "G2G"
                },
                "K2K 몰 구축/리뉴얼": {
                    works: ["EG019", "EG020", "FA036"],
                    dependency: "K2K"
                },
                "K2G 몰 구축/리뉴얼": {
                    works: ["FA785", "FA786"],
                    dependency: "K2G"
                },
                "G2G 몰 구축/리뉴얼": {
                    works: ["FA835", "FA836"],
                    dependency: "G2G"
                }
            }
        };

        // Function to create work item with code, title, and engine label
        function createWorkItem(workCode) {
            const title = workTitles[workCode] || 'Title not found';
            const isEngine = engineData[workCode];
            const engineLabel = isEngine === true ? '<span class="engine-tag">ENGINE</span>' : '';
            const mallCount = getMallCountForTask(workCode);
            const mallLabel = mallCount > 0 ? `<span class="mall-count-label" onclick="showMallDetailsPopup('${workCode}')" title="${mallCount} malls requested to turn off this task">${mallCount} malls</span>` : '';
            return `<span class="work-code">${workCode}</span> - ${title}${engineLabel}${mallLabel}`;
        }

        // Toggle collapse functionality for team sections
        function toggleTeam(teamTitle) {
            const teamSection = teamTitle.parentElement;
            teamSection.classList.toggle('team-collapsed');
        }

        // Toggle collapse functionality for mall information
        function toggleMallInfo(header) {
            const mallList = header.nextElementSibling;
            const icon = header.querySelector('.mall-collapse-icon');
            
            header.classList.toggle('collapsed');
            mallList.classList.toggle('collapsed');
        }

        // Mall to modules mapping (for now just PRM2, will be expanded)
        const mallModuleMapping = {
            'ipposong2:1': ['PRM2'],
            'haveainc:1': ['PRM2'],
            'haveainc:2': ['PRM2'],
            'brighton00:1': ['CSTKK', 'PRM2', 'PRMTKK'],
            'bromptonmall:1': ['PRM1', 'PRM2'],
            'happymajung:1': ['PRM2'],
            'raimdrug:1': ['PRM2'],
            'mouvepoint:1': ['PRM2', 'PRMTKK'],
            'mouvepoint:3': ['PRM2'],
            'riahfolla:1': ['PRM2', 'PRMTKK'],
            'earthmall:1': ['PRM2'],
            'housea0912:1': ['PRM2', 'PRMTKK'],
            'nbnlkr:1': ['PRM2', 'PRM4'],
            'kkliming:1': ['PRM1', 'PRM2'],
            'phn0808:1': ['PRM1', 'PRM2', 'PRM4'],
            'jonsstyle:1': ['PRM2'],
            'ocoomall83:1': ['PRM2'],
            'ocoomall83:4': ['PRM2'],
            'jdaidl:1': ['PRM2', 'PRM3', 'PRM4'],
            'gimaummall:1': ['PRM2'],
            'urbanpapa:1': ['PRM2', 'PRM4'],
            'alrokitchen:1': ['PRM2', 'PRM3', 'PRM4'],
            'yearning128:1': ['PRM1', 'PRM2'],
            'lyclinc1:1': ['PRM2'],
            'lyclinc1:13': ['PRM2'],
            'amierkorea:1': ['PRM2'],
            'amierkorea:2': ['PRM2'],
            'amierkorea:3': ['PRM2'],
            'welcare1:1': ['PRM2'],
            'deersm:1': ['PRM2'],
            'cici3913:1': ['PRM2', 'PRM3', 'PRM4'],
            'etheroom:1': ['PRM2'],
            'alleno17:1': ['PRM2'],
            'sfriendly:1': ['PRM1', 'PRM2'],
            'thethis:1': ['PRM2'],
            'thethis:6': ['PRM2'],
            'jennyoverwillow:1': ['PRM2'],
            'lazurina001:1': ['PRM2', 'PRM3', 'PRM4'],
            'melideco:1': ['PRM2'],
            'melideco:3': ['PRM2'],
            'nature0622:1': ['PRM2'],
            'seouli00:1': ['PRM2'],
            'davidhanbiz:1': ['PRM2'],
            'davidhanbiz:4': ['PRM2'],
            'faurea:1': ['PRM2'],
            'zkxkals1:1': ['PRM2'],
            'yyl033123:1': ['PRM2'],
            'yyl033123:2': ['PRM2'],
            'ortho110:1': ['PRM2'],
            'choyeonhong:1': ['PRM2'],
            'loveenb:1': ['PRM2'],
            'loveenb:4': ['PRM2'],
            'ppituru:1': ['PRM1', 'PRM2'],
            'plac01:1': ['PRM2'],
            'odlykr:1': ['PRM1', 'PRM2'],
            'mtgcrew4:1': ['PRM2'],
            'currentbrown:1': ['PRM2'],
            'surfea:1': ['PRM2'],
            'lapla:1': ['PRM1', 'PRM2'],
            'ahaps0:1': ['PRM2'],
            'nw4668:1': ['PRM2'],
            'dressvtia:1': ['PRM2'],
            'dressvtia:6': ['PRM2'],
            'formlich:1': ['PRM1', 'PRM2'],
            'dduk2141:1': ['PRM1', 'PRM2'],
            'dduk2141:8': ['PRM2'],
            'howkidsful:1': ['PRM2'],
            'ehdudtyd123:1': ['PRM2'],
            'mereconte:1': ['PRM2'],
            'dkvorxhfl:1': ['PRM2'],
            'xrider9221:1': ['PRM1', 'PRM2'],
            'sonokongtoy:1': ['PRM2'],
            'sonokongtoy:6': ['PRM2'],
            'foren88:1': ['PRM2'],
            'itiscoolthing:1': ['PRM2'],
            'bmuet0119:1': ['PRM1', 'PRM2'],
            'lemetier84:1': ['PRM2'],
            'seokyung2030:1': ['PRM1', 'PRM2'],
            'nubo:1': ['PRM2'],
            'cortte:1': ['PRM2'],
            'cortte:5': ['PRM2'],
            'elchltd002:1': ['PRM2'],
            'yoons0723:1': ['PRM2'],
            'jchardwarestore:1': ['PRM2'],
            'lemondetoxkorea1:1': ['PRM2'],
            'dayone5:1': ['PRM2'],
            'lemnos:1': ['PRM2'],
            'candlesoapstory:1': ['PRM1', 'PRM2'],
            'candlesoapstory:4': ['PRM1', 'PRM2'],
            'candlesoapstory:15': ['PRM1', 'PRM2'],
            'ilhwa1:1': ['PRM2'],
            'eumakplus:1': ['PRM2'],
            'rugumsp:1': ['PRM2'],
            'aibel0:1': ['PRM2'],
            'ptjcorp:1': ['PRM2'],
            'ptjcorp:7': ['PRM2'],
            'oddville:1': ['PRM2'],
            'mahasukha:1': ['PRM1', 'PRM2'],
            'lalahomekr:1': ['PRM2'],
            'kyong3542:1': ['PRM2'],
            'ksk0027:1': ['PRM2'],
            'ksb455:1': ['PRM2'],
            'gkduddl2207:1': ['PRM1', 'PRM2'],
            'gkduddl2207:6': ['PRM2'],
            'murrenbeauty:1': ['PRM2'],
            'murrenbeauty:2': ['PRM2'],
            'lepisodekorea:1': ['PRM2'],
            'bmfa97:1': ['PRM2'],
            'bmfa97:6': ['PRM2'],
            'muhan88:1': ['PRM2'],
            'muhan88:5': ['PRM2'],
            'thedaall2:1': ['PRM1', 'PRM2'],
            'studiogarin1:1': ['PRM2'],
            'dooodle:1': ['CSTKK', 'PRM2'],
            'tsuvary:1': ['PRM2'],
            'buddyboo:1': ['PRM2'],
            'buddyboo:2': ['PRM2'],
            'edu25h:1': ['PRM2'],
            'edu25h:5': ['PRM2'],
            'convenii:1': ['PRM2'],
            'convenii:6': ['PRM2'],
            'colorun:1': ['PRM2'],
            'colorun:2': ['PRM2'],
            'kdhmall2020:1': ['CSTKK', 'PRM2'],
            'comfas:1': ['PRM1', 'PRM2'],
            'snpeshop:1': ['PRM2'],
            'mocmo24:1': ['PRM2'],
            'romp:1': ['PRM1', 'PRM2'],
            'romp:7': ['PRM1', 'PRM2'],
            'beaudamo:1': ['PRM2'],
            'jungjikmall2:1': ['PRM2'],
            'mcgun:1': ['PRM2'],
            'mcgun:2': ['PRM2'],
            'wnsgh13077:1': ['PRM2'],
            'mrcf:1': ['PRM1', 'PRM2'],
            'bysec2022:1': ['PRM2'],
            'bysec2022:7': ['PRM2'],
            'ideacrew8434:1': ['PRM2'],
            'wdrobe0507:1': ['PRM1', 'PRM2'],
            'gnlwns1504:1': ['PRM2'],
            'negativethree3:1': ['PRM2'],
            'alsdud0810:1': ['PRM2'],
            'chinni22:1': ['PRM2'],
            'trendpick00:1': ['PRM2'],
            'trendpick00:2': ['PRM2'],
            'muziktiger:1': ['PRM2'],
            'bogobiomall:1': ['PRM2'],
            'bogobiomall:2': ['PRM2'],
            'coozinmall:1': ['PRM1', 'PRM2'],
            'coozinmall:3': ['PRM2'],
            'wingbling:1': ['PRM2'],
            'wingbling:12': ['PRM2'],
            'moveaura:1': ['PRM2'],
            'c9ttang:1': ['PRM2'],
            'hiwons:1': ['PRM2'],
            'pestoyoil:1': ['PRM2'],
            'pestoyoil:3': ['PRM2'],
            'acebiome1234:1': ['PRM2'],
            'organiccyclean:1': ['PRM2'],
            'hosanna83:1': ['PRM2'],
            'hosanna83:2': ['PRM2'],
            'aromame77:1': ['PRM2'],
            'narostar:1': ['PRM2'],
            'alstkd13579:1': ['PRM1', 'PRM2'],
            'brmudkorea:1': ['PRM2'],
            'daehwa01:1': ['PRM2'],
            'knifemall1:1': ['PRM2'],
            'knifemall1:3': ['PRM2'],
            'fractal14:1': ['CSTKK', 'PRM1', 'PRM2', 'PRMTKK'],
            'changefit1:1': ['PRM2'],
            'mysellkr:1': ['CSTKK', 'PRM2', 'PRMTKK'],
            'eaahofficial:1': ['PRM2'],
            'xxixx0580:1': ['PRM2'],
            'xxixx0580:5': ['PRM2'],
            'xxixx0580:6': ['PRM2'],
            'imallpmg:1': ['PRM2'],
            'useit:1': ['PRM2'],
            'nobigdeal2022:1': ['PRM2'],
            'afloral:1': ['PRM1', 'PRM2'],
            'afloral:7': ['PRM1', 'PRM2'],
            'guildstore:1': ['PRM2'],
            'supernova2012:1': ['PRM2'],
            'hipeekaboo:1': ['PRM2'],
            'son4368:1': ['PRM2'],
            'ubsstore4377:1': ['CSTKK', 'PRM2', 'PRMTKK'],
            'ubsstore4378:1': ['CSTKK', 'PRM2', 'PRMTKK'],
            'crewlinks:1': ['PRM2'],
            'rawrow:1': ['CSTKK', 'PRM2', 'PRMTKK'],
            'menuad:1': ['PRM1', 'PRM2'],
            'goodorverygood:1': ['PRM2'],
            'kind3312:1': ['PRM2'],
            'luff101:1': ['PRM1', 'PRM2'],
            'sinsia1024:1': ['PRM2'],
            'ire0:1': ['PRM1', 'PRM2'],
            'liptongg:1': ['PRM1', 'PRM2', 'PRM3', 'PRM5', 'PRMTKK'],
            'chairchair:1': ['PRM2'],
            'snongline:1': ['CSTKK', 'PAUSE', 'PRM1', 'PRM2', 'PRMTKK'],
            'fngbelab:1': ['PRM2'],
            'ballvic:1': ['PRM2'],
            'ballvic:7': ['PRM2'],
            'minizzang7:1': ['PRM1', 'PRM2'],
            'minizzang7:2': ['PRM2'],
            'pfpp:1': ['PRM2'],
            'haancare1:1': ['PRM1', 'PRM2'],
            'haancare1:3': ['PRM1', 'PRM2'],
            'haancare1:4': ['PRM1', 'PRM2'],
            'haancare1:5': ['PRM1', 'PRM2'],
            'coffeehc:1': ['PRM2'],
            'ebur2231:1': ['PRM2'],
            'waverock5:1': ['PRM2', 'PRM5'],
            // PRM5 specific malls
            'ninestar01:1': ['PRM5'],
            'liptongg:1': ['PRM2', 'PRM5'],
            'fornurse1004:1': ['PRM5'],
            'equalife:1': ['PRM5'],
            'yangbongnh:1': ['PRM5'],
            // PRM1 specific malls
            'zzann:1': ['PRM1'],
            'marineteo:1': ['PRM1'],
            'doblab:1': ['PRM1'],
            'doblab:5': ['PRM1'],
            'sabona:1': ['PRM1'],
            'kidsno1:1': ['PRM1'],
            'pluz12:1': ['PRM1'],
            'gopacific:1': ['PRM1', 'PRM4'],
            'hacie1:1': ['PRM1'],
            'santa002:1': ['PRM1'],
            'santa002:2': ['PRM1'],
            'productonline:1': ['PRM1', 'PRM3', 'PRM4'],
            'sytrend:1': ['PRM1'],
            'ntbacon:1': ['PRM1'],
            'cedartree26:1': ['PRM1'],
            'funflex:1': ['PRM1'],
            'funflex:9': ['PRM1'],
            'sonnetcorp:1': ['PRM1'],
            'heysummerkr:1': ['PRM1'],
            'smartmask:1': ['PRM1'],
            'colordin:1': ['PRM1'],
            'clearlab100:1': ['PRM1'],
            'medireturn:1': ['PRM1'],
            'fldakr:1': ['PRM1'],
            'lgkhjg:1': ['PRM1'],
            'lgkhjg:2': ['PRM1'],
            'abluerkw:1': ['PRM1'],
            'groupys992:1': ['PRM1'],
            'groupys772:1': ['PRM1'],
            'aromaticlabshop:1': ['PRM1', 'PRM3'],
            'kottiuomo:1': ['PRM1'],
            'mytheo411:1': ['PRM1'],
            'jksikim7:1': ['PRM1'],
            'thedreampartner:1': ['PRM1'],
            'veining:1': ['PRM1'],
            'plasia22:1': ['PRM1'],
            'skincoding:1': ['PRM1'],
            'broisterkor:1': ['PRM1'],
            'broisterkor:5': ['PRM1'],
            'acud2025:1': ['PRM1'],
            'acud2025:2': ['PRM1'],
            'drpbg77:1': ['PRM1'],
            'supporty1:1': ['PRM1'],
            'artigel:1': ['PRM1'],
            'barchive23:1': ['PRM1'],
            'jjkids4031:10': ['PRM1'],
            'maruwell12:1': ['PRM1'],
            'brandiz0312:1': ['PRM1'],
            'biggaia77:1': ['PRM1'],
            'kangnam4596:1': ['PRM1'],
            'imdoremi:1': ['PRM1'],
            'ai1474:1': ['PRM1'],
            'ai1474:6': ['PRM1'],
            'tgfnb5242:1': ['PRM1'],
            'lingseoul2:1': ['PRM1'],
            'tiacom:2': ['PRM1'],
            'tiacom:3': ['PRM1'],
            'tiacom:6': ['PRM1'],
            'shyoff:1': ['PRM1'],
            'noticevasam:1': ['PRM1'],
            'fabcache:1': ['PRM1'],
            'tracy90020:1': ['PRM1'],
            'nightsaren:1': ['PRM1'],
            'equalby:1': ['PRM1'],
            'groupys993:1': ['PRM1'],
            'mainsun1:1': ['PRM1'],
            'djaaksp9911:1': ['PRM1'],
            'unidiet:1': ['PRM1'],
            'phytopecia:1': ['PRM1'],
            'few1:1': ['PRM1'],
            'sngy:1': ['PRM1'],
            'buty1:1': ['PRM1'],
            'misslab:1': ['PRM1'],
            'thesionco:1': ['PRM1'],
            'thesionco:2': ['PRM1'],
            'kuroshio83:1': ['PRM1'],
            'wadi8002:1': ['PRM1'],
            'piscess1:1': ['PRM1'],
            'bis90:1': ['PRM1'],
            'drumgarage02:1': ['PRM1'],
            'ludojewelry:1': ['PRM1'],
            'okmijnpl2535:1': ['PRM1'],
            'grounded:1': ['PRM1'],
            'tokyo123:1': ['PRM1'],
            'flipflower:1': ['PRM1'],
            'glamwell:1': ['PRM1'],
            'elevenmay:1': ['PRM1'],
            'bymisoswim:1': ['PRM1'],
            'systempler:4': ['PRM1'],
            'skyminji7:1': ['PRM1'],
            'yamagobo1:1': ['PRM1'],
            'mindgood:1': ['PRM1'],
            'xmiss2004:1': ['PRM1'],
            'masscon:1': ['PRM1', 'PRM4'],
            // PRM4 specific malls
            'mivrine:1': ['PRM3', 'PRM4'],
            'richgirlcafe:1': ['PRM3', 'PRM4'],
            'kkotppang1622:1': ['PRM4'],
            'lovelingjewelry:1': ['PRM4'],
            'workonit:1': ['PRM3', 'PRM4'],
            'admdada:1': ['PRM3', 'PRM4'],
            'admdada:4': ['PRM3', 'PRM4'],
            'kindabite:1': ['PRM4'],
            'goodthinkmall:1': ['PRM3', 'PRM4'],
            'moire2930:1': ['PRM4'],
            'ngumall:1': ['PRM3', 'PRM4'],
            'txorbs96:1': ['PRM4'],
            'ari240201:1': ['PRM3', 'PRM4'],
            'maisseoul:1': ['PRM4'],
            'admin19:1': ['PRM4'],
            'paulsboutique1:1': ['PRM4'],
            'sktea:1': ['PRM3', 'PRM4'],
            'jtesoro103:1': ['PRM3', 'PRM4'],
            'dongwha7112:1': ['PRM4'],
            'teeth319:1': ['PRM4'],
            'commonnuovo1:1': ['PRM4'],
            'wriggling:1': ['PRM4'],
            'shin25641:1': ['PRM4'],
            'doodress:1': ['PRM4'],
            'cacle09:1': ['PRM4'],
            'ch0i3180:1': ['PRM4'],
            'dcollec:1': ['PRM4'],
            'moden12345:1': ['PRM4'],
            'moden12345:3': ['PRM4'],
            'ddalku79:1': ['PRM4'],
            'themoon85:1': ['PRM4'],
            'bilybabybily:1': ['PRM4'],
            'instinctus1:1': ['PRM4'],
            'eminandpaul75:1': ['PRM4'],
            'viare0:1': ['PRM4'],
            'elizabeth88admin:1': ['PRM4'],
            'fobico:1': ['PRM4'],
            'teddytales:1': ['PRM4'],
            'teddytales:3': ['PRM4'],
            'gripswany:1': ['PRM4'],
            'gripswany:2': ['PRM4'],
            'dressuad:1': ['PRM4'],
            'omittedkr:1': ['PRM4'],
            'omittedkr:4': ['PRM4'],
            'juyabet:1': ['PRM4'],
            'levdance:1': ['PRM4'],
            'hoyeonnn12:1': ['PRM4'],
            'hoyeonnn12:2': ['PRM4'],
            'sr101:1': ['PRM4'],
            'mev706:1': ['PRM4'],
            'onzak:1': ['PRM4'],
            'legodtofficial:1': ['PRM4'],
            'brooksbrothers:1': ['PRM4'],
            'lifeofficial:4': ['PRM4'],
            'kiehif:1': ['PRM4'],
            'harugonggan:1': ['PRM4'],
            'dalbangoo12:1': ['PRM4'],
            'piumuniform1:1': ['PRM4'],
            'chaewoodak:1': ['PRM4'],
            'lijamong18:1': ['PRM4'],
            'collagekorea:1': ['PRM4'],
            // PRM3 specific malls
            'rollendar:1': ['PRM3'],
            'eastblue8282:1': ['PRM3'],
            'allbe11:1': ['PRM3'],
            // PAUSE specific malls
            'itiscoolthing:1': ['PAUSE'],
            'lemetier84:1': ['PAUSE'],
            'lalahomekr:1': ['PAUSE'],
            'tsuvary:1': ['PAUSE'],
            'jungjikmall2:1': ['PAUSE'],
            'mcgun:1': ['PAUSE'],
            'wnsgh13077:1': ['PAUSE'],
            'bysec2022:7': ['PAUSE'],
            'wingbling:1': ['PAUSE'],
            'wingbling:12': ['PAUSE'],
            'pestoyoil:1': ['PAUSE'],
            'legodtofficial:1': ['PAUSE'],
            'brooksbrothers:1': ['PAUSE'],
            'rockportbki:1': ['PAUSE'],
            'odenserepresent:1': ['PAUSE'],
            'lifeofficial:4': ['PAUSE'],
            'pyrenexhome:1': ['PAUSE'],
            'ppcompany1:1': ['PAUSE'],
            'ebur2231:1': ['PAUSE'],
            
            // PRMTKK specific malls
            'shamel8286:1': ['PRMTKK'],
            'gopacific:1': ['PRMTKK'],
            'mivrine:1': ['PRMTKK'],
            'kkliming:1': ['PRMTKK'],
            'richgirlcafe:1': ['PRMTKK'],
            'ryqhrahf:1': ['PRMTKK'],
            'ryqhrahf:2': ['PRMTKK'],
            'ryqhrahf:7': ['PRMTKK'],
            'jonsstyle:1': ['PRMTKK'],
            'workonit:1': ['PRMTKK'],
            'gimaummall:1': ['PRMTKK'],
            'productonline:1': ['PRMTKK'],
            'urbanpapa:1': ['PRMTKK'],
            'hs9779:1': ['PRMTKK'],
            'ninestar01:1': ['PRMTKK'],
            'alrokitchen:1': ['PRMTKK'],
            'yearning128:1': ['PRMTKK'],
            'goodthinkmall:1': ['PRMTKK'],
            'lyclinc1:1': ['PRMTKK'],
            'ngumall:1': ['PRMTKK'],
            'deersm:1': ['PRMTKK'],
            'ari240201:1': ['PRMTKK'],
            'etheroom:1': ['PRMTKK'],
            'sp89114:1': ['PRMTKK'],
            'thethis:1': ['PRMTKK'],
            'thethis:6': ['PRMTKK'],
            'jennyoverwillow:1': ['PRMTKK'],
            'lazurina001:1': ['PRMTKK'],
            'melideco:1': ['PRMTKK'],
            'nature0622:1': ['PRMTKK'],
            'seouli00:1': ['PAUSE', 'PRMTKK'],
            'spcare01:1': ['PRMTKK'],
            'spcare01:2': ['PRMTKK'],
            'gpoutdoors:1': ['PRMTKK'],
            'jtesoro103:1': ['PRMTKK'],
            'ppituru:1': ['PRMTKK'],
            'plac01:1': ['PRMTKK'],
            'toweljongga:1': ['PRMTKK'],
            'mtgcrew4:1': ['PRMTKK'],
            'skincoding:1': ['PRMTKK'],
            'surfea:1': ['PRMTKK'],
            'nw4668:1': ['PRMTKK'],
            'artplex:1': ['PRMTKK'],
            'dduk2141:1': ['PRMTKK'],
            'wriggling:1': ['PRMTKK'],
            'howkidsful:1': ['PRMTKK'],
            'shin25641:1': ['PRMTKK'],
            'ehdudtyd123:1': ['PRMTKK'],
            'ch0i3180:1': ['PRMTKK'],
            'sonokongtoy:1': ['PRMTKK'],
            'dcollec:1': ['PRMTKK'],
            'bmuet0119:1': ['PRMTKK'],
            'seokyung2030:1': ['PRMTKK'],
            'maruwell12:1': ['PRMTKK'],
            'nubo:1': ['PRMTKK'],
            'cortte:1': ['PRMTKK'],
            'elchltd002:1': ['PRMTKK'],
            'livinbalance:1': ['PRMTKK'],
            'dayone5:1': ['PRMTKK'],
            'lemnos:1': ['PRMTKK'],
            'candlesoapstory:1': ['PRMTKK'],
            'candlesoapstory:4': ['PRMTKK'],
            'candlesoapstory:15': ['PRMTKK'],
            'eumakplus:1': ['PRMTKK'],
            'bilybabybily:1': ['PRMTKK'],
            'eminandpaul75:1': ['PRMTKK'],
            'fobico:1': ['PRMTKK'],
            'oddville:1': ['PRMTKK'],
            'mahasukha:1': ['PRMTKK'],
            'kyong3542:1': ['PRMTKK'],
            'beadstamin:1': ['PRMTKK'],
            'beadstamin:4': ['PRMTKK'],
            'shyoff:1': ['PRMTKK'],
            'ksk0027:1': ['PRMTKK'],
            'ksb455:1': ['PRMTKK'],
            'gkduddl2207:1': ['PRMTKK'],
            'bmfa97:1': ['PRMTKK'],
            'goldrony:1': ['PRMTKK'],
            'muhan88:1': ['PRMTKK'],
            'thedaall2:1': ['PRMTKK'],
            'teddytales:1': ['PRMTKK'],
            'teddytales:3': ['PRMTKK'],
            'dressuad:1': ['PRMTKK'],
            'moospo:1': ['PRMTKK'],
            'alzkql2:1': ['PRMTKK'],
            'buddyboo:1': ['PAUSE', 'PRMTKK'],
            'buddyboo:2': ['PAUSE'],
            'juyabet:1': ['PRMTKK'],
            'edu25h:1': ['PRMTKK'],
            'edu25h:5': ['PRMTKK'],
            'colorun:1': ['PRMTKK'],
            'comfas:1': ['PRMTKK'],
            'mocmo24:1': ['PRMTKK'],
            'romp:1': ['PRMTKK'],
            'romp:7': ['PRMTKK'],
            'mrcf:1': ['PRMTKK'],
            'fingerheel:1': ['PRMTKK'],
            'ideacrew8434:1': ['PRMTKK'],
            'yousunwkd777:1': ['PRMTKK'],
            'gnlwns1504:1': ['PRMTKK'],
            'negativethree3:1': ['PRMTKK'],
            'alsdud0810:1': ['PRMTKK'],
            'igotprice:1': ['PRMTKK'],
            'levdance:1': ['PRMTKK'],
            'heriter:1': ['PRMTKK'],
            'chinni22:1': ['PRMTKK'],
            'sr101:1': ['PRMTKK'],
            'mev706:1': ['PRMTKK'],
            'trendpick00:1': ['PRMTKK'],
            'muziktiger:1': ['PRMTKK'],
            'bogobiomall:1': ['PRMTKK'],
            'hyunnyong:5': ['FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eveningmoon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ltob:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bronis:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lsm30663:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gyrnr7965:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kviruslab0806:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soosanseowon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'baron211:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'classicgusto1:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lampzzz:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'exitguard:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rowand2021:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zdaa:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'graceyun85:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hw9410:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'performans2062:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'iegoet:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oustaleti:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'veena:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dusk121:18': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'affiner928:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'baimint:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'love4rang48:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nosendus:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gukbofnb:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'muoeng1104:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'atoogel:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chcamping:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tishglobal:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ntold:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daonnuri12:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'waboso617:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daeyuapparel:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lumoswear:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'riderpia:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'slimfoxofficial:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'deopda:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'createmlab:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'barundoor:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'echopear:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coffeemanna:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jiggu70:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'style5959:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dltkddnjs620:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jjy102088:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'adore4:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koko0972:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jook0301:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'recipetmall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'woolong03:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maljastore:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'h1shop:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jr0182:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jjulim1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'perfumeryhouse:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'flourishing:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ferrarv:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'halin1998:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bigro:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lycka633:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zingyzingy:26': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wondoobj:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'takzimall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rileyofficial22:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tlqkfenffl:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'manavis7:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gift97718999:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'onatin9:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vvvip91:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dreamgirls94:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ckusun:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tdlbiolab:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beautyinside2019:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dubaiholic:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kbabeauty:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oneday1piano:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'turtlerkorea:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dreamdreamny:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'everybot001:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pacc1:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'corp109:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sono1912:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'edview:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'madametiramisu:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'onemorekor:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'healmindbody:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'buddiz:14': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'itaewonpost2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'd116fighter:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'allgagu:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rubatodesign:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'so8888:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hyoje1579:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'apharmhealth:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'purchasingagent1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'azure203:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pressco5755:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daon3333:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mydeepbluememori:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'comebyus:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'niff34:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'spielhause:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lillimom:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'spielhause01:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dudqls050230:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'elecommerce:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cacazone:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'welltreat1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kokacharm:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mktg6077:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'morningkyu:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'colorkoreanet:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ddmsox:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gur6479:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mmonone:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'newohpcompany:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cherrycraft:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'puer1:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kimoo02:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bosuk1125:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dlwlsdud2404:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dlarnlgh:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fruit13500:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'irisccc:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cej5905:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dongseok1987:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'clasto:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'circaa:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'joyketo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yjuni0307:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kingmaker101:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vioizz:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'megabeez:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ohandki:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dding0823:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'neocommerce3:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'crashet:24': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kiang:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yepooni71:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wednesdayoff:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mog2b:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jyes1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ehyun0223:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'woojoosuper:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'broisterkor:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'arounddawn:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yj0617:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'qkrdlsgh00000:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mybellhouse:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hanully:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sabona:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jungmin5709:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fromgroup:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bentiflexier:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goldcandy7:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'reallygoods:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drlepeintre:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cloudco:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'healingrass00:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zzyena:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ahco2023:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mayi0519:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mildaymon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'emotiveshop:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kimka0812:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rawearth:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ddorimlive:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dressvtia:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yyl033123:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kkokko1968:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'xogus2326:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'terry4236:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pglobal:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'min77min:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drsheva:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'helsel:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nzcjapan:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'namjaeyg:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hwhale25:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'uplabs:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'basasboy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'madamade:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tpm2dreamers:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bandohw:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thebill5066:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'marklight:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nuara:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wonmicoop:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mangoart818:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'unimuse:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'iamfoodhome:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'teeth319:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'laphael38:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'winderlover:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gungangsa:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ictus1004:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bro09:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jh0225l:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'a150509:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'carn01:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'omnipick:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tjgus5719:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eogod5112:14': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goldhorse72:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daldaldome:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pangshin:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'commonnuovo1:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coverqueen:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dotori24:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'planfunny:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mutualproduct1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hongjamaefarm:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'martino93:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cgoods2020:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wwkkdd0:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kommodvintage:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hebtique:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'secret17:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hyeummstudio1425:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thejinjugo:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'acud2025:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'binsoon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'brighten09:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'raraishop:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sciencefun:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kojinsusa:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kmrostar:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'catapille:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kclubcokr:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ghdchdl95:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'future12:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hoesawon:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'le5mai:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'danbisystem:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cubics24:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'minju5584:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thecomma09:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tvstand21:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'negev:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dduk2141:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hoolie:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ny49855:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hana472:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'marvelio:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tojongwon:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'armbiom:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'freakynormal:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'purefriends:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'alchanfood001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'storejedidiah:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rinyu:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'slx9256:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hnsoonsu:14': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'namooibeauty:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gfapparel:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mp7835285:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'loarte:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jansmakr:14': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yjcompany1017:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drkimsformula:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'collectmall:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nailstyle:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bonjourmarch:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bogobiomall:2': ['PRMTKK'],
            'coozinmall:1': ['PRMTKK'],
            'moveaura:1': ['PRMTKK'],
            'hiwons:1': ['PRMTKK'],
            'onzak:1': ['PRMTKK'],
            'na820617:1': ['PRMTKK'],
            'hosanna83:1': ['PRMTKK'],
            'hosanna83:2': ['PRMTKK'],
            'narostar:1': ['PRMTKK'],
            'alstkd13579:1': ['PRMTKK'],
            'karman0826:1': ['PRMTKK'],
            'karman0826:8': ['PRMTKK'],
            'brmudkorea:1': ['PRMTKK'],
            'knifemall1:1': ['PRMTKK'],
            'changefit1:1': ['PRMTKK'],
            'eaahofficial:1': ['PRMTKK'],
            'tuobag:1': ['PRMTKK'],
            'grounded:1': ['PRMTKK'],
            'xxixx0580:1': ['PAUSE', 'PRMTKK'],
            'imallpmg:1': ['PRMTKK'],
            'useit:1': ['PAUSE', 'PRMTKK'],
            'nobigdeal2022:1': ['PRMTKK'],
            'afloral:1': ['PRMTKK'],
            'afloral:7': ['PRMTKK'],
            'guildstore:1': ['PRMTKK'],
            'supernova2012:1': ['PRMTKK'],
            'hipeekaboo:1': ['PRMTKK'],
            'son4368:1': ['PRMTKK'],
            'crewlinks:1': ['PRMTKK'],
            'menuad:1': ['PRMTKK'],
            'goodorverygood:1': ['PRMTKK'],
            'luff101:1': ['PRMTKK'],
            'sinsia1024:1': ['PRMTKK'],
            'elevenmay:1': ['PRMTKK'],
            'elevenmay:5': ['PRMTKK'],
            'jungsungeun:1': ['PRMTKK'],
            'ire0:1': ['PRMTKK'],
            'designheal:1': ['PRMTKK'],
            'ozonz:1': ['PRMTKK'],
            'chairchair:1': ['PRMTKK'],
            'fornurse1004:1': ['PRMTKK'],
            'lijamong18:1': ['PRMTKK'],
            'fngbelab:1': ['PRMTKK'],
            'skyminji7:1': ['PRMTKK'],
            'ballvic:1': ['PRMTKK'],
            'ballvic:7': ['PRMTKK'],
            'minizzang7:1': ['PRMTKK'],
            'mindgood:1': ['PRMTKK'],
            'xmiss2004:1': ['PRMTKK'],
            'waverock5:1': ['PRMTKK'],
            'equalife:1': ['PRMTKK'],
            
            // CSTKK specific malls
            'premale:1': ['CSTKK'],
            'furnituredotcom:1': ['CSTKK', 'PRMTKK']
        };

        // Mall task off requests - stores which tasks are disabled for specific malls
        const mallTaskOffRequests = {
            'zoonimal:1': ['FA013'],
            'allbe11:1': ['FA013'],
            'ipposong2:1': ['FA061', 'FA062', 'FA063', 'FA066', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA113', 'FA114', 'FA115', 'FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA007', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA025', 'FA026', 'FA085', 'FA087', 'FA093', 'FA023', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA052', 'FA053', 'FA125', 'FA080', 'FA081', 'FA082', 'FA094', 'FA095', 'FA096', 'FA097', 'FA071', 'FA074', 'FA075', 'FA090', 'FA091', 'FA120', 'FA121', 'FA067', 'FA072', 'FA073', 'FA112', 'FA076', 'FA077', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA108', 'FA109', 'FA070', 'FA110', 'FA111', 'FA078', 'FA079', 'FA098'],
            'apollostore:1': ['FA064', 'FA066', 'FA106', 'FA060', 'FA041'],
            'znftiqpxm:1': ['FA064'],
            'borysoo1:1': ['FA060'],
            'dhflcnrrn:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA206', 'FA208'],
            'earthmall:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA206', 'FA208'],
            'healthm24:1': ['FA185', 'FA186', 'FA187', 'FA188', 'FA205', 'FA207', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213'],
            'parkkiseong1215:1': ['FA041'],
            'hansamincare:1': ['FA106'],
            'cosmoenc1:1': ['FA030'],
            'daelimcare3667:1': ['FA041'],
            'dokuonline:1': ['FA030'],
            'kgroomer:1': ['FA030'],
            'woolam23:1': ['FA064'],
            'raimdrug:1': ['FA087'],
            'ted0486:1': ['FA221'],
            'shopbetters:1': ['FA221'],
            'wndms0626:6': ['FA230'],
            'pine2018:1': ['FA066'],
            'edaehotoys:1': ['FA030'],
            'lizme2022:1': ['FA221'],
            'brianaofficial:1': ['FA030'],
            'medavita1:1': ['FA030'],
            'doublej0301:1': ['FA221'],
            'bookendinc:1': ['FA030'],
            'shelter2024:1': ['FA030'],
            'primangus:1': ['FA030'],
            'dearelly:1': ['FA041'],
            'happymajung:1': ['FA087'],
            'saja9980:1': ['FA030'],
            'designonoff:1': ['EG003', 'FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA007', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242'],
            'mnem:1': ['FA087', 'FA184', 'FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'alleno17:1': ['FA184'],
            'abn2024:1': ['FA184'],
            'lemondetoxkorea1:1': ['FA087'],
            'ocoomall83:1': ['FA184'],
            'ocoomall83:4': ['FA184'],
            'snugu:1': ['FA184'],
            'leatherless:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'jjkids4031:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'faurea:1': ['FA184'],
            'lemetier84:1': ['FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'contactnear:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'itiscoolthing:1': ['FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'motleystuff:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'balasana:1': ['FA150'],
            'murrenbeauty:1': ['FA184'],
            'lepisodekorea:1': ['FA184'],
            'mimikk7:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'maket612:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'egojinm:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'convenii:1': ['FA184'],
            'ilhwa1:1': ['FA184'],
            'ceuticals:1': ['FA184'],
            'jdaidl:1': ['FA184'],
            'ahaps0:1': ['FA184'],
            'eumakplus:1': ['FA184'],
            'ortho110:1': ['FA184'],
            'diditinc:1': ['FA184'],
            'welcare1:1': ['FA184'],
            'dayone5:1': ['FA184'],
            'yyl033123:1': ['FA184'],
            'jchardwarestore:1': ['FA184'],
            'sfriendly:1': ['FA184'],
            'zkxkals1:1': ['FA184'],
            'nbnlkr:1': ['FA184'],
            'davidhanbiz:1': ['FA184'],
            'tsuvary:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'wnsgh13077:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'letterfrommoon:5': ['FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'semong21:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'skin9lab:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thanksmomshop:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koalgroup:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'akwo55:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hullife168:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mochibongbong:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tbchadamso:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'woodlerental:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maisonines:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hansanggung1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kinderhalla:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'modoodarkzip:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'littlepantry:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gnroom001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lowaroom:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'inbae6119:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'luvyooa:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jknv:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kkkmall4661:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'prettygirlsshop:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'painstudy:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'laufco:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aribell:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ekwjd64:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'howooling:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ytbabyhaus:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'themallfabric:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'modiquekorea12:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'grotto2011:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'idahunt7680:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tngh5531:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'leemeister3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maelee08:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wantj:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'anamalz:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'quicksmart2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'qurebaby:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'car5007:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dokuonline:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jyvsptv777:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'angeblanc:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sortiedesign:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hktoolsnet:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'didar951:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'namutech0:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'petsteward1004:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maiohwmai77:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'circlepack12345:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'micorp88:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'borysoo1:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cedartree26:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'itsstreet:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shjinne1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tigeramuk2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sunup1218:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hausofchic:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lgeezoun:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'funflex:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wimico:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ecobizman:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aminoinc:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bsm1991:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'marqurie:14': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gjyedam1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'h201shift:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zoonimal:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'noblecloset:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beautynutri:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hjjdream1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nksigdangmasters:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mamufact:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cinthesong:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sperusmall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'auroraklay:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cocochoi2040:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'marketone17:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'japong:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'leean357:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nemopacktory1:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mersh10:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'redstar1:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shop3355go:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'clothshop1:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vfr900:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bpla:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tj06:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ndotique:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'switchon31:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'srkflatform:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tablestorykr:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ndarna:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'okmarket12:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lookappy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'betterlife82:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hidaeq:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'callihouse:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sinjimoru01:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            's12cho001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hellocamping1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ystrader0514:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ledande99:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dongwooweltech:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hale7292:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'min8729:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'deocs:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'machya1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lagnjin1:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'iknsys:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'purpborn:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'peacefulpicnic8:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'erulecorp:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'restupmall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'catdp:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dframeplatform1:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dlaeo88:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fishtable2022:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wpop77:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chiclab:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'miniduct:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koreahealthedu:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dressvill83:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vibee2024:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eponakorea:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'made111:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'leenyeong:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wallaroo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sol0925:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'igsesang:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'droregonin:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doteum01:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'newflow2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'makebbbak:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dduckhamji12:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'benettonmat:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sweetydreams:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'stu0315:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'txstory:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'blanchardkorea:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'growm:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'noiseismylife:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'muoeng1104:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doraji30:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gkstmvns3646:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'diel24:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drbrianmall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eyeon24:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nzoriginmall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dalbambeauty:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yeunna11:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'naknakfishing:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'iambooming:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'modudapanda:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'upperspot:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soliberty:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ggam252:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kbrandmarket01:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'avecbike:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'diskpckman:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rosadesign:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wndms0626:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kranzle1:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wycomp:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hanwoomam:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sk44166:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ajestory1:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'asla:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'junwood:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dynatoneshop:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'taggrip:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'artbooster:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'playlive1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'refusi:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'asqw4381:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'adfootfilter:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bsaudiokr:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'salttong:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'uluru4:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'viamonoh0409:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nboxs:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'psfd:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sungyeongwang:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lch2440:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wedolove:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'quvstore:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fruitsanta:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kmgutest250210:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gurum044:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ormo001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ibh7777:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'welllive:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lyclinc1:13': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gangwhabbq:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lemaha:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yeowulnuri:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dohacompany10:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ingterior:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jachinco:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doublej0301:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'brwaterfull:22': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'olg50004:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mrjunosport:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'arc0320:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mariekimok:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sunchildcolove:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'be4me:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'meideme:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'guitiku:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zanne1122:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'predok:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'muktiorganics:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'greenfog:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'duplicolor:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hashblanc:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ejrgnek2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'faithhealth:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'riakyj:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dainvenus:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'furchs:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'glifemanon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ifthat:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'samwonehb1:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sopistylekorea:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'krnr:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'egglim1:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hj0628:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'c0nniewoo:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lovely1854:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gomdalgoo:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'joytomtom:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'birinnemall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sundro21:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mdgn24:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'stylishellya:15': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'scentmod:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'admdada:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'brianaofficial:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yskim06:20': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'metadronejsy01:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'heraclas96:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'carcomstore:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'seaman6777:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'upcyclist:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lone1love:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'newn20:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wonhang71:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shoesn100:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'imb778899:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'miraclescorp:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'flowshops:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kimrabbit8848:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'whiteapple20:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soojichim2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sohe03:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'songe615:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ted0486:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jhtgb3167:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'baegmaoutdoor:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'callihouse:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soundmakerweb:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'comppp:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mygyeomi:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jungsh31:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lalahomekr:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'beaudamo:1': ['FA184'],
            'koreastamp2:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'ilovelnc:1': ['FA150'],
            'wingbling:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'kingscore:1': ['FA086'],
            'h201shift:1': ['FA087', 'FA184'],
            'pyrenexhome:1': ['FA087', 'FA184'],
            'rockportbki:1': ['FA087', 'FA184'],
            'odenserepresent:1': ['FA087', 'FA184'],
            'hoverlabmall:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'lifeofficial:4': ['FA087', 'FA184'],
            'good0131:1': ['FA184'],
            'muziktiger:1': ['FA184'],
            'commonnuovo1:1': ['FA086'],
            'studiogarin1:1': ['FA184'],
            'mysellkr:1': ['FA150'],
            'guildstore:1': ['FA086'],
            'hiwons:1': ['FA086'],
            'supernova2012:1': ['FA086'],
            'aromame77:1': ['FA184'],
            'lapla:1': ['FA184'],
            'alrokitchen:1': ['FA184'],
            'surfea:1': ['FA087'],
            'eaahofficial:1': ['FA184'],
            'center714:1': ['FA184'],
            'healthm24:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sukkitchen:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cocoblanc123:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cleanpick:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'happy064:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tkssoemf1230:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mepure5530:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maxn:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sujungcom1:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'greenvoi:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'piercingkorea001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'w12pearl:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'captaincrazy:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'benoco:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vineofficial27:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sualc7432:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'youandme38:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coeurcompany:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'santa002:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dustn4582:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'benewnail:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hhl0128:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'demind23:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'damiella:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wannabelikedoha:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'colorheal:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'flooow:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lovelingjewelry:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soyoumasil1:13': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'loveallday:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ladda:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'moon28:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jssound:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'anarchia:17': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fjqnznfk:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'everahot:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'high113:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smarthome74:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'letterfrommoon:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bonjourmarch:3': ['FA593', 'FA594', 'FA595'],
            'wisefactory:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hankookdnt1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'minidou:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'notnew:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wnsqks9:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cakmul777:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cooldog11:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'market105:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'crafthowl:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hanmaem3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'unscramble:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rmrguatm:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lcplaza08:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jcsok7:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'emol:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rmglobal:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zzepplin:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cheon365a:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thefireday:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'flowertalk0331:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'xjj9427738:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'people4580:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'playboyb62:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gslee136:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'big2love:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ydcompany88:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'graceyoga:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'leseiji33:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'angelsound:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'juicediet001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'youngdino777:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sanctusventures:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'uinme:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cupa3720:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'haseon92:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'withhmax:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'youyong1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'newtamsamall:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'okcheck79:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aebric:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'voevoe2025:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'renonia7:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jce999:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wellflow11:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rfarm3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'loobon:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'millius:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sallimstudio:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lepireshop:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jsugarbebe:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ai1474:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'choumondekorea:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'joylife001:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'janjanbariwave:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'repick001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dawoom25:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kow2034:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ekwjd7084:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tgfnb5242:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'petcrewofficial:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'desirerose:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'meltingbrown:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'leatherless:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'snsystem2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kb5508:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bijoubonbon1224:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fragrance37:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zamvo409:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goodboy892:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gtmkorea:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'alsl0902:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'peteroo:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hanjungss:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sallido1:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'monjou1:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cappuccino920:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'neowells:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'auracur:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wdw77:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hansonsofa2025:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'matini94:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dscmall1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'skin4you1:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wldzh1201:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'loveenb:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'passionate2024:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'opalhouse:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'akimmall:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cnnclean:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'enji7777:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mikve02:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lewklewk001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ceramicdorothy:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eightmore:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'remyj3340:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ptjcorp:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'golffish:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'motioncept:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'siahyang:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pwinwin2:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sweetgirlz:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'madlefood:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rocket1967:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'montegagu1:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yp0879:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'myhomesick:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tiacom:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mkhyunwoo:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'younxjung:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ohkukka:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'twee0401:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'youme030:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'enterconshop:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'realdoctor:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'neoart48:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'getitby:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cinnamonlab:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'skadydtn4234:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pkh8585:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mytable17:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doodoohot:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bigma2:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beadstamin:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wonmax:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yungyungs2:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cong0921:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beautygarden10:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'annesgallery:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beautygarden107:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doridoriboo1701:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'qjarnr:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kimy766:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ocleankorea:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'amicokorea:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chachacrafts:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mx101:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hmbshop:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'malang0522:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'monthlytoy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'baleno:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'roomish:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'purplegreenweb:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'komoon0107:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gkduddl2207:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'missksj123:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dalot:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'averageattitude:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sognomall:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'badakmall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'villainx:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'emimmim21:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ulookyj:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sik0518:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'murrenbeauty:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bmfa97:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rossog3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'byh0906:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yongpowerla:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tuttogato:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gyulfactory:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rose0615:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'essd31:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soon81s:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mygoodmeal:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jnmenter21:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goldrony:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'muhan88:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aislingkorea:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'this5855:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wasabiiii:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'withlabs:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wispet9191:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jintennisacademy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bongbongberry:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chicaura001:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'anderssonbell:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'riwons:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bibijeong:31': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'slowafternoon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ananfood:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tjdk3027:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coino8647:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yeolook0307:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'teddytales:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'moimemine:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'amongku:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gml486:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chict45:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'doorins:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jsy4121:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'moon12440:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'orca2019:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dressuad:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wjskfma81:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'glasias6467:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bigdoggy2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yiyo1237:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'econealthy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'johansonlife:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wansomall:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'remyremy:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'onepeck86:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gyuri8090:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coffeelovely:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kopas3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thepetkorea:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'annurcabio:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lesonel:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chosunhnb:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fitcock2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mieumjieut:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jh8726:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drgreenbio:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'homoludenskorea:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'grit2025:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'benita:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hmc361723:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lks2420:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mimikk7:22': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sonic032:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'restinger:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yyam7142:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beaurysome:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nnnooohhh56:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gkqrlehtjdgh001:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'styletiba3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kgangy:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dereborujo:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lyunanlyuna:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'secondalley:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tpgus432:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rarityshop:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sunkimchi2003:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'urbanage01:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oy193cm:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'omittedkr:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hnrsports:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'momoartist:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mnj5101:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'buddyboo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lplay:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pengphone:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fiores:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'naosumi:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kjs0927:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gongganchaeum:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'minseo82:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koskoline:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'juyabet:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shelton1:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'egojinm:29': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'praisedh:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rosikofficial24:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dcollec:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nagaua55bb:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'keonjong1:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'woojinco113:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'convenii:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dccoffee:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aromacomall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'samtech7:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dalbitroasting:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'onna125:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aidstore:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kkyungmink:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'heyday2024:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nn1466:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'seedfarm:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'demerdi:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'con7982:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shespop:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'drnatural2020:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dexonia:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'soundlook:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kh1267:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'colorun:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wmstudio13:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'xoqor1506:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ariderma20:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'exsnow:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'stylebymiin:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'akstjq91:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'skylakemain:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'spotlighting:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hongsgg:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nailppang1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'snpeshop:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'luxgirl2015:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nthink624:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'topsellpick:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'reboundws:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'haish23:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'togiyo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eunsam2089:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'secretinkara:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'peache25:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'capinhat:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kgmiracle2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yourgreen:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'evofitgolf:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'boheme7777:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wondertree7:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'robeauty:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coloragent2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smo0th2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'romp:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'imchampion94:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'esac1:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ttang7202:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sc240101:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'caihong700502:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cx1121:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'diditinc:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'haystack:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'geulgrida72:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'funiturs:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mcgun:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wlstn12311:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'scmarket001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'olivegown8:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smg8005:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'spmk:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'parkha1412:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ntplab72:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bsj1206:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'annasports:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rlawoals9182:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daewoongbio1000:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sjfighter6:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sjlee24:21': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'saysaysayboy:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'saurashop:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'myjaje:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'reify1:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'maxminton:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'locoflowershop:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tazan2456:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bodong82:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yukubin:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'etcsoftmall:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kjmkjm12:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ollus:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jellykiss:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'okokmart1:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'veriveri2025:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'vlup:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'styleareyou2022:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'healthebom:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sapark01:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'chikuk1207:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'discode23:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'adxotn:13': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jinygolf7:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'horeca11:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oaworld2488:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'meownew:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'alivelabshop:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bysec2022:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kuntai:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'brothersf:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'essenq:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goodlux02:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'noomer2023:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cindy38383838:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'route185:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jubongcompany:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ss4774:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'andgraycoffee:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kkn7179:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jlife0510:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'labowell:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'good0131:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'medubcokr:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daopanda2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'premium02:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daopanda:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'buildusshop:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mingso000:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sefian2253:15': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ch0528:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'narich0719:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nalraon:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gbec11:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wardognyc:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dake1811:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nyeric:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yousunwkd777:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gallipot:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sweetmi3:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'magodicasa:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'goble:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sooah3059:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oduck2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kukdae24:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pocax2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jxhoonilizm:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yoa89:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jwj1000ja:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sscocompany2:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lupeo32:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ujutech:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sangsamall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dameunbojagi:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'enoufy:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'merrymax99:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'juyeooh001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kent8829:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ohneulbom:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'urbancore2025:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dodoplate:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'playbigsilver:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ryqhrahf:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smh0048:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oksewoo:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jiyoo888:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fill001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bebebreath:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eartstudio:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'neosense:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'luvmojito:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cafealtro:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'markone001:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'coric:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aonesports:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'shopsoonsoo:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ywgfmall:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cey0720:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dashcrabmall:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ramerit:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'igotprice:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'continew675:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'palcheonn:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'regler:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'laglow:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sixmeal:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jiyeonius:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yhank2:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hairybirdbox0:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'minirecipekr:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bucketgram:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'inno40:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dlrbgud0111:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'morgancoffee:10': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gustavinc:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nar2kkk:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'eri1030:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'luckyccs2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'flobi:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'stefood:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smart1001:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mamayu:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bindingcrabs4u:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'theways:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'twang777:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pangs120:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'arimcloset:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hoyeonnn12:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'adeva:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'egarden1:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gyeolhaus:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'korearmc:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'matele:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wkdal123456:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ramii2:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'keoin92:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'seems3:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'daall02:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'enemoline:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'awooli:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'owncloset2021:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'returnqueen:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'differppl:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koreanapparel0:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sciencecamp:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ouilara:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'caraz:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'marketbanjang:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hyeminwon2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sr101:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sbeyondint:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'boom2004:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'inwol7:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'linden1004:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'damdashop:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'clinis72:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'allfresh777:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'cnm3290:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wognsdlssk:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wapworks:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'outdoorlandm1:8': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'holy21000:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'su1644:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'trendpick00:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gaonbest:12': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'anderssonbell:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'rjsdnaka37:9': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ya3805:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'damicompany:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'buyingfitness:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'todnakt:16': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'darkism:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'niceguy7052:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oio4375:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mondaytosun:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'felicea98:11': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'podogaji:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kyrie09:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hoverlabmall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thethis:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bamsunie:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'jmsmw12:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oddslove81:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'krnr2025:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kbiblecraft:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lolence2:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'anypull88:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hauon0622:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kuraanna:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'prototie:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'power4u:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'workfriend:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hera770:7': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ceo16885954:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pumjiljoa:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'koreastamp2:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zaq9611:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yeawoo27:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sefetyu7:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mauveit01:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'imdron:5': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'misscococo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smartlee96:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zdaa33:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'minossurf:4': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kimsj590815:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA576', 'FA577', 'FA578', 'FA579', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA588', 'FA589', 'FA590', 'FA591', 'FA592', 'FA593', 'FA594', 'FA595'],
            'foodparty001:3': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA088', 'FA089', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA222', 'FA223', 'FA224', 'FA225', 'FA226', 'FA227', 'FA228', 'FA229', 'FA230', 'FA231', 'FA232', 'FA233', 'FA234', 'FA235', 'FA236', 'FA237', 'FA238', 'FA239', 'FA240', 'FA241', 'FA242', 'FA243', 'FA244', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA256', 'FA257', 'FA258', 'FA259', 'FA260', 'FA261', 'FA262', 'FA263', 'FA264', 'FA265', 'FA266', 'FA267', 'FA268', 'FA269', 'FA270', 'FA271', 'FA272', 'FA273', 'FA274', 'FA275', 'FA276', 'FA277', 'FA278', 'FA279', 'FA280', 'FA281', 'FA282', 'FA283', 'FA284', 'FA285', 'FA286', 'FA287', 'FA288', 'FA289', 'FA290', 'FA291', 'FA292', 'FA293', 'FA294', 'FA295', 'FA296', 'FA297', 'FA298', 'FA299', 'FA300', 'FA301', 'FA302', 'FA303', 'FA304', 'FA305', 'FA306', 'FA307', 'FA308', 'FA309', 'FA310', 'FA311', 'FA312', 'FA313', 'FA314', 'FA315', 'FA316', 'FA317', 'FA318', 'FA319', 'FA320', 'FA321', 'FA322', 'FA323', 'FA324', 'FA325', 'FA326', 'FA327', 'FA328', 'FA329', 'FA330', 'FA331', 'FA332', 'FA333', 'FA334', 'FA335', 'FA336', 'FA337', 'FA338', 'FA339', 'FA340', 'FA341', 'FA342', 'FA343', 'FA344', 'FA345', 'FA346', 'FA347', 'FA348', 'FA349', 'FA350', 'FA351', 'FA352', 'FA353', 'FA354', 'FA355', 'FA356', 'FA357', 'FA358', 'FA359', 'FA360', 'FA361', 'FA362', 'FA363', 'FA364', 'FA365', 'FA366', 'FA367', 'FA368', 'FA369', 'FA370', 'FA371', 'FA372', 'FA373', 'FA374', 'FA375', 'FA376', 'FA377', 'FA378', 'FA379', 'FA380', 'FA381', 'FA382', 'FA383', 'FA384', 'FA385', 'FA386', 'FA387', 'FA388', 'FA389', 'FA390', 'FA391', 'FA392', 'FA393', 'FA394', 'FA395', 'FA396', 'FA397', 'FA398', 'FA399', 'FA400', 'FA401', 'FA402', 'FA403', 'FA404', 'FA405', 'FA406', 'FA407', 'FA408', 'FA409', 'FA410', 'FA411', 'FA412', 'FA413', 'FA414', 'FA415', 'FA416', 'FA417', 'FA418', 'FA419', 'FA420', 'FA421', 'FA422', 'FA423', 'FA424', 'FA425', 'FA426', 'FA427', 'FA428', 'FA429', 'FA430', 'FA431', 'FA432', 'FA433', 'FA434', 'FA435', 'FA436', 'FA437', 'FA438', 'FA439', 'FA440', 'FA441', 'FA442', 'FA443', 'FA444', 'FA445', 'FA446', 'FA447', 'FA448', 'FA449', 'FA450', 'FA451', 'FA452', 'FA453', 'FA454', 'FA455', 'FA456', 'FA457', 'FA458', 'FA459', 'FA460', 'FA461', 'FA462', 'FA463', 'FA464', 'FA465', 'FA466', 'FA467', 'FA468', 'FA469', 'FA470', 'FA471', 'FA472', 'FA473', 'FA474', 'FA475', 'FA476', 'FA477', 'FA478', 'FA479', 'FA480', 'FA481', 'FA482', 'FA483', 'FA484', 'FA485', 'FA486', 'FA487', 'FA488', 'FA489', 'FA490', 'FA491', 'FA492', 'FA493', 'FA494', 'FA495', 'FA496', 'FA497', 'FA498', 'FA499', 'FA500', 'FA501', 'FA502', 'FA503', 'FA504', 'FA505', 'FA506', 'FA507', 'FA508', 'FA509', 'FA510', 'FA511', 'FA512', 'FA513', 'FA514', 'FA515', 'FA516', 'FA517', 'FA518', 'FA519', 'FA520', 'FA521', 'FA522', 'FA523', 'FA524', 'FA525', 'FA526', 'FA527', 'FA528', 'FA529', 'FA530', 'FA531', 'FA532', 'FA533', 'FA534', 'FA535', 'FA536', 'FA537', 'FA538', 'FA539', 'FA540', 'FA541', 'FA542', 'FA543', 'FA544', 'FA545', 'FA546', 'FA547', 'FA548', 'FA549', 'FA550', 'FA551', 'FA552', 'FA553', 'FA554', 'FA555', 'FA556', 'FA557', 'FA558', 'FA559', 'FA560', 'FA561', 'FA562', 'FA563', 'FA564', 'FA565', 'FA566', 'FA567', 'FA568', 'FA569', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA576', 'FA577', 'FA578', 'FA579', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA588', 'FA589', 'FA590', 'FA591', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hens77:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA088', 'FA089', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA222', 'FA223', 'FA224', 'FA225', 'FA226', 'FA227', 'FA228', 'FA229', 'FA230', 'FA231', 'FA232', 'FA233', 'FA234', 'FA235', 'FA236', 'FA237', 'FA238', 'FA239', 'FA240', 'FA241', 'FA242', 'FA243', 'FA244', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA256', 'FA257', 'FA258', 'FA259', 'FA260', 'FA261', 'FA262', 'FA263', 'FA264', 'FA265', 'FA266', 'FA267', 'FA268', 'FA269', 'FA270', 'FA271', 'FA272', 'FA273', 'FA274', 'FA275', 'FA276', 'FA277', 'FA278', 'FA279', 'FA280', 'FA281', 'FA282', 'FA283', 'FA284', 'FA285', 'FA286', 'FA287', 'FA288', 'FA289', 'FA290', 'FA291', 'FA292', 'FA293', 'FA294', 'FA295', 'FA296', 'FA297', 'FA298', 'FA299', 'FA300', 'FA301', 'FA302', 'FA303', 'FA304', 'FA305', 'FA306', 'FA307', 'FA308', 'FA309', 'FA310', 'FA311', 'FA312', 'FA313', 'FA314', 'FA315', 'FA316', 'FA317', 'FA318', 'FA319', 'FA320', 'FA321', 'FA322', 'FA323', 'FA324', 'FA325', 'FA326', 'FA327', 'FA328', 'FA329', 'FA330', 'FA331', 'FA332', 'FA333', 'FA334', 'FA335', 'FA336', 'FA337', 'FA338', 'FA339', 'FA340', 'FA341', 'FA342', 'FA343', 'FA344', 'FA345', 'FA346', 'FA347', 'FA348', 'FA349', 'FA350', 'FA351', 'FA352', 'FA353', 'FA354', 'FA355', 'FA356', 'FA357', 'FA358', 'FA359', 'FA360', 'FA361', 'FA362', 'FA363', 'FA364', 'FA365', 'FA366', 'FA367', 'FA368', 'FA369', 'FA370', 'FA371', 'FA372', 'FA373', 'FA374', 'FA375', 'FA376', 'FA377', 'FA378', 'FA379', 'FA380', 'FA381', 'FA382', 'FA383', 'FA384', 'FA385', 'FA386', 'FA387', 'FA388', 'FA389', 'FA390', 'FA391', 'FA392', 'FA393', 'FA394', 'FA395', 'FA396', 'FA397', 'FA398', 'FA399', 'FA400', 'FA401', 'FA402', 'FA403', 'FA404', 'FA405', 'FA406', 'FA407', 'FA408', 'FA409', 'FA410', 'FA411', 'FA412', 'FA413', 'FA414', 'FA415', 'FA416', 'FA417', 'FA418', 'FA419', 'FA420', 'FA421', 'FA422', 'FA423', 'FA424', 'FA425', 'FA426', 'FA427', 'FA428', 'FA429', 'FA430', 'FA431', 'FA432', 'FA433', 'FA434', 'FA435', 'FA436', 'FA437', 'FA438', 'FA439', 'FA440', 'FA441', 'FA442', 'FA443', 'FA444', 'FA445', 'FA446', 'FA447', 'FA448', 'FA449', 'FA450', 'FA451', 'FA452', 'FA453', 'FA454', 'FA455', 'FA456', 'FA457', 'FA458', 'FA459', 'FA460', 'FA461', 'FA462', 'FA463', 'FA464', 'FA465', 'FA466', 'FA467', 'FA468', 'FA469', 'FA470', 'FA471', 'FA472', 'FA473', 'FA474', 'FA475', 'FA476', 'FA477', 'FA478', 'FA479', 'FA480', 'FA481', 'FA482', 'FA483', 'FA484', 'FA485', 'FA486', 'FA487', 'FA488', 'FA489', 'FA490', 'FA491', 'FA492', 'FA493', 'FA494', 'FA495', 'FA496', 'FA497', 'FA498', 'FA499', 'FA500', 'FA501', 'FA502', 'FA503', 'FA504', 'FA505', 'FA506', 'FA507', 'FA508', 'FA509', 'FA510', 'FA511', 'FA512', 'FA513', 'FA514', 'FA515', 'FA516', 'FA517', 'FA518', 'FA519', 'FA520', 'FA521', 'FA522', 'FA523', 'FA524', 'FA525', 'FA526', 'FA527', 'FA528', 'FA529', 'FA530', 'FA531', 'FA532', 'FA533', 'FA534', 'FA535', 'FA536', 'FA537', 'FA538', 'FA539', 'FA540', 'FA541', 'FA542', 'FA543', 'FA544', 'FA545', 'FA546', 'FA547', 'FA548', 'FA549', 'FA550', 'FA551', 'FA552', 'FA553', 'FA554', 'FA555', 'FA556', 'FA557', 'FA558', 'FA559', 'FA560', 'FA561', 'FA562', 'FA563', 'FA564', 'FA565', 'FA566', 'FA567', 'FA568', 'FA569', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA576', 'FA577', 'FA578', 'FA579', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA588', 'FA589', 'FA590', 'FA591', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ebuu:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA088', 'FA089', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA222', 'FA223', 'FA224', 'FA225', 'FA226', 'FA227', 'FA228', 'FA229', 'FA230', 'FA231', 'FA232', 'FA233', 'FA234', 'FA235', 'FA236', 'FA237', 'FA238', 'FA239', 'FA240', 'FA241', 'FA242', 'FA243', 'FA244', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA256', 'FA257', 'FA258', 'FA259', 'FA260', 'FA261', 'FA262', 'FA263', 'FA264', 'FA265', 'FA266', 'FA267', 'FA268', 'FA269', 'FA270', 'FA271', 'FA272', 'FA273', 'FA274', 'FA275', 'FA276', 'FA277', 'FA278', 'FA279', 'FA280', 'FA281', 'FA282', 'FA283', 'FA284', 'FA285', 'FA286', 'FA287', 'FA288', 'FA289', 'FA290', 'FA291', 'FA292', 'FA293', 'FA294', 'FA295', 'FA296', 'FA297', 'FA298', 'FA299', 'FA300', 'FA301', 'FA302', 'FA303', 'FA304', 'FA305', 'FA306', 'FA307', 'FA308', 'FA309', 'FA310', 'FA311', 'FA312', 'FA313', 'FA314', 'FA315', 'FA316', 'FA317', 'FA318', 'FA319', 'FA320', 'FA321', 'FA322', 'FA323', 'FA324', 'FA325', 'FA326', 'FA327', 'FA328', 'FA329', 'FA330', 'FA331', 'FA332', 'FA333', 'FA334', 'FA335', 'FA336', 'FA337', 'FA338', 'FA339', 'FA340', 'FA341', 'FA342', 'FA343', 'FA344', 'FA345', 'FA346', 'FA347', 'FA348', 'FA349', 'FA350', 'FA351', 'FA352', 'FA353', 'FA354', 'FA355', 'FA356', 'FA357', 'FA358', 'FA359', 'FA360', 'FA361', 'FA362', 'FA363', 'FA364', 'FA365', 'FA366', 'FA367', 'FA368', 'FA369', 'FA370', 'FA371', 'FA372', 'FA373', 'FA374', 'FA375', 'FA376', 'FA377', 'FA378', 'FA379', 'FA380', 'FA381', 'FA382', 'FA383', 'FA384', 'FA385', 'FA386', 'FA387', 'FA388', 'FA389', 'FA390', 'FA391', 'FA392', 'FA393', 'FA394', 'FA395', 'FA396', 'FA397', 'FA398', 'FA399', 'FA400', 'FA401', 'FA402', 'FA403', 'FA404', 'FA405', 'FA406', 'FA407', 'FA408', 'FA409', 'FA410', 'FA411', 'FA412', 'FA413', 'FA414', 'FA415', 'FA416', 'FA417', 'FA418', 'FA419', 'FA420', 'FA421', 'FA422', 'FA423', 'FA424', 'FA425', 'FA426', 'FA427', 'FA428', 'FA429', 'FA430', 'FA431', 'FA432', 'FA433', 'FA434', 'FA435', 'FA436', 'FA437', 'FA438', 'FA439', 'FA440', 'FA441', 'FA442', 'FA443', 'FA444', 'FA445', 'FA446', 'FA447', 'FA448', 'FA449', 'FA450', 'FA451', 'FA452', 'FA453', 'FA454', 'FA455', 'FA456', 'FA457', 'FA458', 'FA459', 'FA460', 'FA461', 'FA462', 'FA463', 'FA464', 'FA465', 'FA466', 'FA467', 'FA468', 'FA469', 'FA470', 'FA471', 'FA472', 'FA473', 'FA474', 'FA475', 'FA476', 'FA477', 'FA478', 'FA479', 'FA480', 'FA481', 'FA482', 'FA483', 'FA484', 'FA485', 'FA486', 'FA487', 'FA488', 'FA489', 'FA490', 'FA491', 'FA492', 'FA493', 'FA494', 'FA495', 'FA496', 'FA497', 'FA498', 'FA499', 'FA500', 'FA501', 'FA502', 'FA503', 'FA504', 'FA505', 'FA506', 'FA507', 'FA508', 'FA509', 'FA510', 'FA511', 'FA512', 'FA513', 'FA514', 'FA515', 'FA516', 'FA517', 'FA518', 'FA519', 'FA520', 'FA521', 'FA522', 'FA523', 'FA524', 'FA525', 'FA526', 'FA527', 'FA528', 'FA529', 'FA530', 'FA531', 'FA532', 'FA533', 'FA534', 'FA535', 'FA536', 'FA537', 'FA538', 'FA539', 'FA540', 'FA541', 'FA542', 'FA543', 'FA544', 'FA545', 'FA546', 'FA547', 'FA548', 'FA549', 'FA550', 'FA551', 'FA552', 'FA553', 'FA554', 'FA555', 'FA556', 'FA557', 'FA558', 'FA559', 'FA560', 'FA561', 'FA562', 'FA563', 'FA564', 'FA565', 'FA566', 'FA567', 'FA568', 'FA569', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA576', 'FA577', 'FA578', 'FA579', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA588', 'FA589', 'FA590', 'FA591', 'FA592', 'FA593', 'FA594', 'FA595'],
            'tobaggie15:5': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA052', 'FA053', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA076', 'FA077', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA088', 'FA089', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA128', 'FA129', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA173', 'FA174', 'FA175', 'FA176', 'FA177', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA222', 'FA223', 'FA224', 'FA225', 'FA226', 'FA227', 'FA228', 'FA229', 'FA230', 'FA231', 'FA232', 'FA233', 'FA234', 'FA235', 'FA236', 'FA237', 'FA238', 'FA239', 'FA240', 'FA241', 'FA242', 'FA243', 'FA244', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA256', 'FA257', 'FA258', 'FA259', 'FA260', 'FA261', 'FA262', 'FA263', 'FA264', 'FA265', 'FA266', 'FA267', 'FA268', 'FA269', 'FA270', 'FA271', 'FA272', 'FA273', 'FA274', 'FA275', 'FA276', 'FA277', 'FA278', 'FA279', 'FA280', 'FA281', 'FA282', 'FA283', 'FA284', 'FA285', 'FA286', 'FA287', 'FA288', 'FA289', 'FA290', 'FA291', 'FA292', 'FA293', 'FA294', 'FA295', 'FA296', 'FA297', 'FA298', 'FA299', 'FA300', 'FA301', 'FA302', 'FA303', 'FA304', 'FA305', 'FA306', 'FA307', 'FA308', 'FA309', 'FA310', 'FA311', 'FA312', 'FA313', 'FA314', 'FA315', 'FA316', 'FA317', 'FA318', 'FA319', 'FA320', 'FA321', 'FA322', 'FA323', 'FA324', 'FA325', 'FA326', 'FA327', 'FA328', 'FA329', 'FA330', 'FA331', 'FA332', 'FA333', 'FA334', 'FA335', 'FA336', 'FA337', 'FA338', 'FA339', 'FA340', 'FA341', 'FA342', 'FA343', 'FA344', 'FA345', 'FA346', 'FA347', 'FA348', 'FA349', 'FA350', 'FA351', 'FA352', 'FA353', 'FA354', 'FA355', 'FA356', 'FA357', 'FA358', 'FA359', 'FA360', 'FA361', 'FA362', 'FA363', 'FA364', 'FA365', 'FA366', 'FA367', 'FA368', 'FA369', 'FA370', 'FA371', 'FA372', 'FA373', 'FA374', 'FA375', 'FA376', 'FA377', 'FA378', 'FA379', 'FA380', 'FA381', 'FA382', 'FA383', 'FA384', 'FA385', 'FA386', 'FA387', 'FA388', 'FA389', 'FA390', 'FA391', 'FA392', 'FA393', 'FA394', 'FA395', 'FA396', 'FA397', 'FA398', 'FA399', 'FA400', 'FA401', 'FA402', 'FA403', 'FA404', 'FA405', 'FA406', 'FA407', 'FA408', 'FA409', 'FA410', 'FA411', 'FA412', 'FA413', 'FA414', 'FA415', 'FA416', 'FA417', 'FA418', 'FA419', 'FA420', 'FA421', 'FA422', 'FA423', 'FA424', 'FA425', 'FA426', 'FA427', 'FA428', 'FA429', 'FA430', 'FA431', 'FA432', 'FA433', 'FA434', 'FA435', 'FA436', 'FA437', 'FA438', 'FA439', 'FA440', 'FA441', 'FA442', 'FA443', 'FA444', 'FA445', 'FA446', 'FA447', 'FA448', 'FA449', 'FA450', 'FA451', 'FA452', 'FA453', 'FA454', 'FA455', 'FA456', 'FA457', 'FA458', 'FA459', 'FA460', 'FA461', 'FA462', 'FA463', 'FA464', 'FA465', 'FA466', 'FA467', 'FA468', 'FA469', 'FA470', 'FA471', 'FA472', 'FA473', 'FA474', 'FA475', 'FA476', 'FA477', 'FA478', 'FA479', 'FA480', 'FA481', 'FA482', 'FA483', 'FA484', 'FA485', 'FA486', 'FA487', 'FA488', 'FA489', 'FA490', 'FA491', 'FA492', 'FA493', 'FA494', 'FA495', 'FA496', 'FA497', 'FA498', 'FA499', 'FA500', 'FA501', 'FA502', 'FA503', 'FA504', 'FA505', 'FA506', 'FA507', 'FA508', 'FA509', 'FA510', 'FA511', 'FA512', 'FA513', 'FA514', 'FA515', 'FA516', 'FA517', 'FA518', 'FA519', 'FA520', 'FA521', 'FA522', 'FA523', 'FA524', 'FA525', 'FA526', 'FA527', 'FA528', 'FA529', 'FA530', 'FA531', 'FA532', 'FA533', 'FA534', 'FA535', 'FA536', 'FA537', 'FA538', 'FA539', 'FA540', 'FA541', 'FA542', 'FA543', 'FA544', 'FA545', 'FA546', 'FA547', 'FA548', 'FA549', 'FA550', 'FA551', 'FA552', 'FA553', 'FA554', 'FA555', 'FA556', 'FA557', 'FA558', 'FA559', 'FA560', 'FA561', 'FA562', 'FA563', 'FA564', 'FA565', 'FA566', 'FA567', 'FA568', 'FA569', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA576', 'FA577', 'FA578', 'FA579', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA588', 'FA589', 'FA590', 'FA591', 'FA592', 'FA593', 'FA594', 'FA595'],
            'oddville:1': ['FA524'],
            'nobigdeal2022:1': ['FA524'],
            'codewind:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'joytime:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'singlai:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'aaa0413:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'synapsis:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ksj7709:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'yibbayibba:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'babeedu:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wngudtkr:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'joongkikids:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lovedot:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wellbeingfoods:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thefrost:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'noonamom:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'gozoo80:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'magicbear:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'thisbest:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'diyc:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'smartblue:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kbproduct:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'topvalue:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'sunupday:3': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'itkorea102:6': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'kookboo:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'pinkchuu:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'theforsale:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'hansolmall:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mjh6488:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dailymate:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'topqkkorea:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'babyco:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'bonobebe:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dongsin:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dohong:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'moonlevel:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'babycoco:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'legodtofficial:1': ['FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221'],
            'h201shift:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512'],
            'oglbrand:2': ['FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'toto1881:3': ['FA001'],
            'ztoglobal23:1': ['FA001'],
            'hanarofs:1': ['FA001'],
            'liptongg:1': ['FA001'],
            'mokster89:1': ['FA001'],
            'banzsunglade:1': ['FA001'],
            'jonsstyle:1': ['FA001'],
            'alsdud0810:1': ['FA001'],
            'kimsh5858:1': ['FA001'],
            'kdu4749:1': ['FA001'],
            'sjkim2025:1': ['FA001'],
            'hansot0519:1': ['FA001'],
            'asdfzxcv12368:1': ['FA001'],
            'jgs0726:1': ['FA001'],
            'gongssam:1': ['FA001'],
            'kdh1995:1': ['FA001'],
            'hjkim3476:1': ['FA001'],
            'lsw3467:1': ['FA001'],
            'yty0424:1': ['FA001'],
            'toto1881:2': ['FA001'],
            'ztoglobal23:3': ['FA001'],
            'hanarofs:3': ['FA001'],
            'liptongg:3': ['FA001'],
            'mokster89:3': ['FA001'],
            'banzsunglade:3': ['FA001'],
            'jonsstyle:3': ['FA001'],
            'alsdud0810:3': ['FA001'],
            'kimsh5858:3': ['FA001'],
            'kdu4749:3': ['FA001'],
            'sjkim2025:3': ['FA001'],
            'hansot0519:3': ['FA001'],
            'asdfzxcv12368:3': ['FA001'],
            'jgs0726:3': ['FA001'],
            'gongssam:3': ['FA001'],
            'kdh1995:3': ['FA001'],
            'hjkim3476:3': ['FA001'],
            'lsw3467:3': ['FA001'],
            'yty0424:3': ['FA001'],
            'toto1881:1': ['FA001'],
            'ztoglobal23:2': ['FA001'],
            'hanarofs:2': ['FA001'],
            'liptongg:2': ['FA001'],
            'mokster89:2': ['FA001'],
            'banzsunglade:2': ['FA001'],
            'jonsstyle:2': ['FA001'],
            'alsdud0810:2': ['FA001'],
            'kimsh5858:2': ['FA001'],
            'kdu4749:2': ['FA001'],
            'sjkim2025:2': ['FA001'],
            'hansot0519:2': ['FA001'],
            'asdfzxcv12368:2': ['FA001'],
            'jgs0726:2': ['FA001'],
            'gongssam:2': ['FA001'],
            'kdh1995:2': ['FA001'],
            'hjkim3476:2': ['FA001'],
            'lsw3467:2': ['FA001'],
            'yty0424:2': ['FA001'],
            'inves502550:2': ['FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'ddballyhoo:5': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'mmoder:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nicehappy0:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'g109jj:6': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'lyclinc1:1': ['FA184'],
            'hyuonjung:9': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'zdaada2:13': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'birdpalace1:10': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'beingbeige:9': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'edu25h:1': ['FA184'],
            'edu25h:5': ['FA184'],
            'yeonss001:5': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'realjade:10': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'teambok1:4': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dddstore:1': ['FA184'],
            'riahfolla:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'ks171019999:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'youngseogarden:3': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'fozlab1:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'dmshopping:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'onoffinterad:2': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'choeunjie:4': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'wlc88:7': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'nyty3030:3': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'widace:7': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595'],
            'studiolaeti:3': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040'],
            'zzagunmarket:2': ['FA123'],
            'seungo09:1': ['FA001'],
            'yongneshop:1': ['FA001'],
            'hyeanmihwa:1': ['FA001'],
            'margofoodlab:1': ['FA001'],
            'nikeeun69:1': ['FA001'],
            'ilovefit7:1': ['FA001'],
            'curioushagi:1': ['FA001'],
            'gint:1': ['FA001'],
            'smalminum1:1': ['FA001'],
            'hjkang118:1': ['FA001'],
            'most2178:1': ['FA001'],
            'conagold:1': ['FA001'],
            'hjkang118:2': ['FA001'],
            'most2178:2': ['FA001'],
            'conagold:2': ['FA001'],
            'hjkang118:3': ['FA001'],
            'most2178:3': ['FA001'],
            'conagold:3': ['FA001'],
            'hjkang118:4': ['FA001'],
            'most2178:4': ['FA001'],
            'conagold:4': ['FA001'],
            'hjkang118:5': ['FA001'],
            'most2178:5': ['FA001'],
            'conagold:5': ['FA001'],
            'hjkang118:6': ['FA001'],
            'most2178:6': ['FA001'],
            'conagold:6': ['FA001'],
            'hjkang118:7': ['FA001'],
            'most2178:7': ['FA001'],
            'conagold:7': ['FA001'],
            'fornurse1004:1': ['FA550'],
            'dknutrition:1': ['FA184'],
            'kimoo02:1': ['FA184'],
            'icilamaison:1': ['FA550'],
            'snongline:1': ['FA550'],
            'snpeshop:1': ['FA550'],
            'goldhorse79:1': ['FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595', 'FA602', 'FA608', 'FA609', 'FA614', 'FA615', 'FA617', 'FA627', 'FA633', 'FA635', 'FA636', 'FA644', 'FA649', 'FA651', 'FA655', 'FA661', 'FA675', 'FA676', 'FA677', 'FA697', 'FA703', 'FA704', 'FA705', 'FA706', 'FA707', 'FA708', 'FA710', 'FA721', 'FA722', 'FA723', 'FA724', 'FA725', 'FA726', 'FA727', 'FA728', 'FA729', 'FA730', 'FA731', 'FA732', 'FA733', 'FA734', 'FA735', 'FA736', 'FA737', 'FA738', 'FA739', 'FA740', 'FA741', 'FA742', 'FA743', 'FA744', 'FA745', 'FA746', 'FA754', 'FA755', 'FA756', 'FA757', 'FA758', 'FA759', 'FA760', 'FA761', 'FA762', 'FA763', 'FA764', 'FA765', 'FA766', 'FA767', 'FA768', 'FA769', 'FA770', 'FA771', 'FA772', 'FA775', 'FA776', 'FA777', 'FA778', 'FA779', 'FA780', 'FA781', 'FA782', 'FA783', 'FA784', 'FA787', 'FA788', 'FA789', 'FA790', 'FA791', 'FA792', 'FA793', 'FA795', 'FA796', 'FA797', 'FA798', 'FA799', 'FA800', 'FA805', 'FA806', 'FA810', 'FA818', 'FA819', 'FA820', 'FA821', 'FA835', 'FA836', 'FA843', 'FA848', 'FA873'],
            'himazone:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'candlesoapstory:1': ['FA550'],
            'candlesoapstory:15': ['FA550'],
            'toweljongga:1': ['FA015', 'FA086', 'FA087', 'FA184'],
            'ebur2231:1': ['FA550'],
            'plleave:1': ['FA184'],
            'nutril:1': ['FA550'],
            'adsl053:1': ['FA550'],
            'dldlemf00000:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'drbronner01:1': ['FA550'],
            'min48jjj:1': ['FA184'],
            'beneater:1': ['FA550'],
            'apollostore:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA061', 'FA062', 'FA063', 'FA065', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595', 'FA602', 'FA608', 'FA609', 'FA614', 'FA615', 'FA617', 'FA627', 'FA633', 'FA635', 'FA636', 'FA644', 'FA649', 'FA651', 'FA655', 'FA661', 'FA675', 'FA676', 'FA677', 'FA697', 'FA703', 'FA704', 'FA705', 'FA706', 'FA707', 'FA708', 'FA710', 'FA721', 'FA722', 'FA723', 'FA724', 'FA725', 'FA726', 'FA727', 'FA728', 'FA729', 'FA730', 'FA731', 'FA732', 'FA733', 'FA734', 'FA735', 'FA736', 'FA737', 'FA738', 'FA739', 'FA740', 'FA741', 'FA742', 'FA743', 'FA744', 'FA745', 'FA746', 'FA754', 'FA755', 'FA756', 'FA757', 'FA758', 'FA759', 'FA760', 'FA761', 'FA762', 'FA763', 'FA764', 'FA765', 'FA766', 'FA767', 'FA768', 'FA769', 'FA770', 'FA771', 'FA772', 'FA775', 'FA776', 'FA777', 'FA778', 'FA779', 'FA780', 'FA781', 'FA782', 'FA783', 'FA784', 'FA787', 'FA788', 'FA789', 'FA790', 'FA791', 'FA792', 'FA793', 'FA795', 'FA796', 'FA797', 'FA798', 'FA799', 'FA800', 'FA805', 'FA806', 'FA810', 'FA818', 'FA819', 'FA820', 'FA821', 'FA835', 'FA836', 'FA843', 'FA848', 'FA873', 'FA915'],
            'brighton00:1': ['FA550'],
            'heysteofficial:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595', 'FA602', 'FA608', 'FA609', 'FA614', 'FA615', 'FA617', 'FA627', 'FA633', 'FA635', 'FA636', 'FA644', 'FA649', 'FA651', 'FA655', 'FA661', 'FA675', 'FA676', 'FA677', 'FA697', 'FA703', 'FA704', 'FA705', 'FA706', 'FA707', 'FA708', 'FA710', 'FA721', 'FA722', 'FA723', 'FA724', 'FA725', 'FA726', 'FA727', 'FA728', 'FA729', 'FA730', 'FA731', 'FA732', 'FA733', 'FA734', 'FA735', 'FA736', 'FA737', 'FA738', 'FA739', 'FA740', 'FA741', 'FA742', 'FA743', 'FA744', 'FA745', 'FA746', 'FA754', 'FA755', 'FA756', 'FA757', 'FA758', 'FA759', 'FA760', 'FA761', 'FA762', 'FA763', 'FA764', 'FA765', 'FA766', 'FA767', 'FA768', 'FA769', 'FA770', 'FA771', 'FA772', 'FA775', 'FA776', 'FA777', 'FA778', 'FA779', 'FA780', 'FA781', 'FA782', 'FA783', 'FA784', 'FA787', 'FA788', 'FA789', 'FA790', 'FA791', 'FA792', 'FA793', 'FA795', 'FA796', 'FA797', 'FA798', 'FA799', 'FA800', 'FA805', 'FA806', 'FA810', 'FA818', 'FA819', 'FA820', 'FA821', 'FA835', 'FA836', 'FA843', 'FA848', 'FA873', 'FA915'],
            'balancedpawsweb:1': ['FA184'],
            'dkvorxhfl:1': ['FA550'],
            'newgulliver:1': ['FA184'],
            'orusi0918:1': ['FA184'],
            'dumsooni:1': ['FA184'],
            'shupong2020:1': ['FA550'],
            'hammaster:1': ['FA001', 'FA017', 'FA019', 'FA022'],
            'dermagency:1': ['FA550'],
            'km0234:1': ['FA550'],
            'podogood:1': ['FA550'],
            'unoverse1126:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'lifeeat2023:1': ['FA550'],
            'popote:1': ['FA184'],
            'eunstar99:1': ['FA184'],
            'bodymindlife:1': ['FA184'],
            'beukay:1': ['FA550'],
            'djaaksp9911:1': ['FA550'],
            'ngjn123:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087'],
            'alfla001:1': ['FA550'],
            'ole1shot:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'iambooming:1': ['FA184'],
            'wisefactory:1': ['FA550'],
            't1shopgg:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595', 'FA602', 'FA608', 'FA609', 'FA614', 'FA615', 'FA617', 'FA627', 'FA633', 'FA635', 'FA636', 'FA644', 'FA649', 'FA651', 'FA655', 'FA661', 'FA675', 'FA676', 'FA677', 'FA697', 'FA703', 'FA704', 'FA705', 'FA706', 'FA707', 'FA708', 'FA710', 'FA721', 'FA722', 'FA723', 'FA724', 'FA725', 'FA726', 'FA727', 'FA728', 'FA729', 'FA730', 'FA731', 'FA732', 'FA733', 'FA734', 'FA735', 'FA736', 'FA737', 'FA738', 'FA739', 'FA740', 'FA741', 'FA742', 'FA743', 'FA744', 'FA745', 'FA746', 'FA754', 'FA755', 'FA756', 'FA757', 'FA758', 'FA759', 'FA760', 'FA761', 'FA762', 'FA763', 'FA764', 'FA765', 'FA766', 'FA767', 'FA768', 'FA769', 'FA770', 'FA771', 'FA772', 'FA775', 'FA776', 'FA777', 'FA778', 'FA779', 'FA780', 'FA781', 'FA782', 'FA783', 'FA784', 'FA787', 'FA788', 'FA789', 'FA790', 'FA791', 'FA792', 'FA793', 'FA795', 'FA796', 'FA797', 'FA798', 'FA799', 'FA800', 'FA805', 'FA806', 'FA810', 'FA818', 'FA819', 'FA820', 'FA821', 'FA835', 'FA836', 'FA843', 'FA848', 'FA873', 'FA915', 'FA917', 'FA922'],
            'athomecosmetic:1': ['FA184'],
            'defemme:1': ['FA184'],
            'dmdv001:1': ['FA006', 'FA008', 'FA015', 'FA086', 'FA087', 'FA184'],
            'wjcosmetics:1': ['FA001', 'FA002', 'FA003', 'FA004', 'FA005', 'FA006', 'FA007', 'FA008', 'FA009', 'FA010', 'FA011', 'FA012', 'FA013', 'FA014', 'FA015', 'FA016', 'FA017', 'FA018', 'FA019', 'FA020', 'FA021', 'FA022', 'FA023', 'FA024', 'FA025', 'FA026', 'FA027', 'FA028', 'FA029', 'FA030', 'FA031', 'FA032', 'FA033', 'FA034', 'FA035', 'FA036', 'FA037', 'FA038', 'FA039', 'FA040', 'FA041', 'FA042', 'FA043', 'FA044', 'FA045', 'FA046', 'FA047', 'FA048', 'FA049', 'FA050', 'FA051', 'FA054', 'FA055', 'FA056', 'FA057', 'FA058', 'FA059', 'FA060', 'FA061', 'FA062', 'FA063', 'FA064', 'FA065', 'FA066', 'FA067', 'FA068', 'FA069', 'FA070', 'FA071', 'FA072', 'FA073', 'FA074', 'FA075', 'FA078', 'FA079', 'FA080', 'FA081', 'FA082', 'FA083', 'FA084', 'FA085', 'FA086', 'FA087', 'FA090', 'FA091', 'FA092', 'FA093', 'FA094', 'FA095', 'FA096', 'FA097', 'FA098', 'FA099', 'FA100', 'FA101', 'FA102', 'FA103', 'FA104', 'FA105', 'FA106', 'FA107', 'FA108', 'FA109', 'FA110', 'FA111', 'FA112', 'FA113', 'FA114', 'FA115', 'FA116', 'FA117', 'FA118', 'FA119', 'FA120', 'FA121', 'FA122', 'FA123', 'FA124', 'FA125', 'FA126', 'FA127', 'FA130', 'FA131', 'FA132', 'FA133', 'FA134', 'FA135', 'FA136', 'FA137', 'FA138', 'FA139', 'FA140', 'FA141', 'FA142', 'FA143', 'FA144', 'FA145', 'FA146', 'FA147', 'FA148', 'FA149', 'FA150', 'FA151', 'FA152', 'FA153', 'FA154', 'FA155', 'FA156', 'FA157', 'FA158', 'FA159', 'FA160', 'FA161', 'FA162', 'FA163', 'FA164', 'FA165', 'FA166', 'FA167', 'FA168', 'FA169', 'FA170', 'FA171', 'FA172', 'FA178', 'FA179', 'FA180', 'FA181', 'FA182', 'FA183', 'FA184', 'FA185', 'FA186', 'FA187', 'FA188', 'FA189', 'FA190', 'FA191', 'FA192', 'FA193', 'FA194', 'FA195', 'FA196', 'FA197', 'FA198', 'FA199', 'FA200', 'FA201', 'FA202', 'FA203', 'FA204', 'FA205', 'FA206', 'FA207', 'FA208', 'FA209', 'FA210', 'FA211', 'FA212', 'FA213', 'FA214', 'FA215', 'FA216', 'FA217', 'FA218', 'FA219', 'FA220', 'FA221', 'FA229', 'FA230', 'FA242', 'FA245', 'FA246', 'FA247', 'FA248', 'FA249', 'FA250', 'FA251', 'FA252', 'FA253', 'FA254', 'FA255', 'FA455', 'FA456', 'FA458', 'FA459', 'FA460', 'FA461', 'FA510', 'FA511', 'FA512', 'FA524', 'FA570', 'FA571', 'FA572', 'FA573', 'FA574', 'FA575', 'FA580', 'FA581', 'FA582', 'FA583', 'FA584', 'FA585', 'FA586', 'FA587', 'FA592', 'FA593', 'FA594', 'FA595', 'FA602', 'FA608', 'FA609', 'FA614', 'FA615', 'FA617', 'FA627', 'FA633', 'FA635', 'FA636', 'FA644', 'FA649', 'FA651', 'FA655', 'FA661', 'FA675', 'FA676', 'FA677', 'FA697', 'FA703', 'FA704', 'FA705', 'FA706', 'FA707', 'FA708', 'FA710', 'FA721', 'FA722', 'FA723', 'FA724', 'FA725', 'FA726', 'FA727', 'FA728', 'FA729', 'FA730', 'FA731', 'FA732', 'FA733', 'FA734', 'FA735', 'FA736', 'FA737', 'FA738', 'FA739', 'FA740', 'FA741', 'FA742', 'FA743', 'FA744', 'FA745', 'FA746', 'FA754', 'FA755', 'FA756', 'FA757', 'FA758', 'FA759', 'FA760', 'FA761', 'FA762', 'FA763', 'FA764', 'FA765', 'FA766', 'FA767', 'FA768', 'FA769', 'FA770', 'FA771', 'FA772', 'FA775', 'FA776', 'FA777', 'FA778', 'FA779', 'FA780', 'FA781', 'FA782', 'FA783', 'FA784', 'FA787', 'FA788', 'FA789', 'FA790', 'FA791', 'FA792', 'FA793', 'FA795', 'FA796', 'FA797', 'FA798', 'FA799', 'FA800', 'FA805', 'FA806', 'FA810', 'FA818', 'FA819', 'FA820', 'FA821', 'FA835', 'FA836', 'FA843', 'FA848', 'FA873', 'FA915', 'FA917', 'FA922'],
            'big2love:1': ['FA184'],
            'soidam:1': ['FA184'],
            'kiseung1990:1': ['FA184']
        };

        // Function to check if a task is disabled for a specific mall
        function isTaskDisabledForMall(mallId, shopNo, taskCode) {
            const mallKey = `${mallId}:${shopNo}`;
            return mallTaskOffRequests[mallKey] && mallTaskOffRequests[mallKey].includes(taskCode);
        }

        // Function to add task off request
        function addTaskOffRequest(mallId, shopNo, taskCode) {
            const mallKey = `${mallId}:${shopNo}`;
            if (!mallTaskOffRequests[mallKey]) {
                mallTaskOffRequests[mallKey] = [];
            }
            if (!mallTaskOffRequests[mallKey].includes(taskCode)) {
                mallTaskOffRequests[mallKey].push(taskCode);
            }
        }

        // Function to remove task off request
        function removeTaskOffRequest(mallId, shopNo, taskCode) {
            const mallKey = `${mallId}:${shopNo}`;
            if (mallTaskOffRequests[mallKey]) {
                mallTaskOffRequests[mallKey] = mallTaskOffRequests[mallKey].filter(task => task !== taskCode);
                if (mallTaskOffRequests[mallKey].length === 0) {
                    delete mallTaskOffRequests[mallKey];
                }
            }
        }

        // Function to count malls that have requested to turn off a specific task
        function getMallCountForTask(taskCode) {
            let count = 0;
            for (const mallKey in mallTaskOffRequests) {
                if (mallTaskOffRequests[mallKey].includes(taskCode)) {
                    count++;
                }
            }
            return count;
        }

        // Function to get mall details for a specific task
        function getMallsForTask(taskCode) {
            const malls = [];
            for (const mallKey in mallTaskOffRequests) {
                if (mallTaskOffRequests[mallKey].includes(taskCode)) {
                    const [mallId, shopNo] = mallKey.split(':');
                    malls.push({ mallId, shopNo });
                }
            }
            return malls;
        }

        // Function to show mall details popup
        function showMallDetailsPopup(taskCode) {
            const malls = getMallsForTask(taskCode);
            const mallCount = malls.length;
            
            if (mallCount === 0) {
                alert('No malls have requested to turn off this task.');
                return;
            }

            // Create popup content
            let popupContent = `
                <div class="mall-popup-overlay" onclick="closeMallPopup()">
                    <div class="mall-popup-content" onclick="event.stopPropagation()">
                        <div class="mall-popup-header">
                            <h3>Task ${taskCode} - Mall Off Requests (${mallCount})</h3>
                            <button class="mall-popup-close" onclick="closeMallPopup()">&times;</button>
                        </div>
                        <div class="mall-popup-body">
                            <div class="mall-list">
            `;
            
            malls.forEach((mall, index) => {
                popupContent += `
                    <div class="mall-item">
                        <span class="mall-info">${mall.mallId} (shop: ${mall.shopNo})</span>
                    </div>
                `;
            });
            
            popupContent += `
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add popup to page
            document.body.insertAdjacentHTML('beforeend', popupContent);
        }

        // Function to close mall details popup
        function closeMallPopup() {
            const popup = document.querySelector('.mall-popup-overlay');
            if (popup) {
                popup.remove();
            }
        }

        // Search function
        function searchMall() {
            const searchTerm = document.getElementById('mallSearch').value.trim().toLowerCase();
            const resultsDiv = document.getElementById('searchResults');
            
            if (!searchTerm) {
                resultsDiv.classList.remove('show');
                return;
            }

            const results = [];
            
            // Search for exact match
            if (mallModuleMapping[searchTerm]) {
                results.push({
                    mall: searchTerm,
                    modules: mallModuleMapping[searchTerm]
                });
            } else {
                // Search for partial matches
                for (const [mall, modules] of Object.entries(mallModuleMapping)) {
                    if (mall.includes(searchTerm)) {
                        results.push({
                            mall: mall,
                            modules: modules
                        });
                    }
                }
            }

            displaySearchResults(results);
        }

        // Navigate to specific module
        function navigateToModule(moduleName) {
            // Find the module header with the matching name
            const headers = document.querySelectorAll('.main-group-header');
            let targetHeader = null;
            
            for (let header of headers) {
                const headerText = header.textContent.trim();
                if (headerText.includes(moduleName)) {
                    targetHeader = header;
                    break;
                }
            }
            
            if (targetHeader) {
                const mainGroup = targetHeader.closest('.main-group');
                
                // First, check if this module is inside a team section and expand the team if needed
                const teamSection = mainGroup.closest('.team-section');
                if (teamSection && teamSection.classList.contains('team-collapsed')) {
                    const teamTitle = teamSection.querySelector('.team-title');
                    if (teamTitle) {
                        teamTitle.click(); // This will expand the team section
                    }
                }
                
                // Small delay to allow team expansion animation to start
                setTimeout(() => {
                    // Expand the module if it's collapsed
                    if (mainGroup && mainGroup.classList.contains('collapsed')) {
                        targetHeader.click(); // This will expand the module
                    }
                    
                    // Scroll to the module with some offset for better visibility
                    setTimeout(() => {
                        targetHeader.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                        
                        // Add a highlight effect
                        mainGroup.style.border = '3px solid #007bff';
                        mainGroup.style.borderRadius = '8px';
                        setTimeout(() => {
                            mainGroup.style.border = '';
                            mainGroup.style.borderRadius = '';
                        }, 2000);
                    }, 200);
                }, 100);
            }
        }

        // Display search results
        function displaySearchResults(results) {
            const resultsDiv = document.getElementById('searchResults');
            
            if (results.length === 0) {
                resultsDiv.innerHTML = '<div class="no-results">No malls found</div>';
                resultsDiv.classList.add('show');
                return;
            }

            let html = '';
            results.forEach(result => {
                html += `
                    <div class="search-result-item">
                        <div class="search-result-mall">${result.mall}</div>
                        <div class="search-result-modules">
                            ${result.modules.map(module => 
                                `<span class="search-result-module clickable-module" onclick="navigateToModule('${module}')" title="Click to go to ${module} module">${module}</span>`
                            ).join('')}
                        </div>
                    </div>
                `;
            });

            resultsDiv.innerHTML = html;
            resultsDiv.classList.add('show');
        }

        // Add new mall assignment
        function addMallAssignment() {
            const taskNumber = document.getElementById('taskNumber').value.trim();
            const mallId = document.getElementById('mallId').value.trim();
            const shopNo = document.getElementById('shopNo').value.trim();
            const resultDiv = document.getElementById('addResult');
            
            // Validation
            if (!taskNumber || !mallId || !shopNo) {
                resultDiv.innerHTML = '❌ Please fill in all fields';
                resultDiv.style.backgroundColor = '#f8d7da';
                resultDiv.style.color = '#721c24';
                resultDiv.style.border = '1px solid #f5c6cb';
                resultDiv.style.display = 'block';
                return;
            }
            
            // Create the mall:shop key
            const mallKey = `${mallId}:${shopNo}`;
            
            // Since no module is specified, this is a general assignment record
            resultDiv.innerHTML = `✅ Successfully recorded assignment:<br><strong>${mallKey}</strong> (Task: ${taskNumber})`;
            resultDiv.style.backgroundColor = '#d4edda';
            resultDiv.style.color = '#155724';
            resultDiv.style.border = '1px solid #c3e6cb';
            resultDiv.style.display = 'block';
            
            // Clear the form
            document.getElementById('taskNumber').value = '';
            document.getElementById('mallId').value = '';
            document.getElementById('shopNo').value = '';
            
            // Hide result after 5 seconds
            setTimeout(() => {
                resultDiv.style.display = 'none';
            }, 5000);
        }

        // Delete mall assignment
        function deleteMallAssignment() {
            const deleteTaskNumber = document.getElementById('deleteTaskNumber').value.trim();
            const deleteMallId = document.getElementById('deleteMallId').value.trim();
            const deleteShopNo = document.getElementById('deleteShopNo').value.trim();
            const resultDiv = document.getElementById('deleteResult');
            
            // Validation
            if (!deleteTaskNumber || !deleteMallId || !deleteShopNo) {
                resultDiv.innerHTML = '❌ Please fill in all fields';
                resultDiv.style.backgroundColor = '#f8d7da';
                resultDiv.style.color = '#721c24';
                resultDiv.style.border = '1px solid #f5c6cb';
                resultDiv.style.display = 'block';
                return;
            }
            
            // Create the mall:shop key
            const mallKey = `${deleteMallId}:${deleteShopNo}`;
            
            // Check if this mall:shop exists
            if (!mallModuleMapping[mallKey]) {
                resultDiv.innerHTML = `❌ ${mallKey} not found in any module`;
                resultDiv.style.backgroundColor = '#f8d7da';
                resultDiv.style.color = '#721c24';
                resultDiv.style.border = '1px solid #f5c6cb';
                resultDiv.style.display = 'block';
                return;
            }
            
            const originalModules = [...mallModuleMapping[mallKey]];
            
            // Remove from ALL modules since no specific module is selected
            delete mallModuleMapping[mallKey];
            resultDiv.innerHTML = `✅ Completely removed ${mallKey} from all modules<br><small>Task: ${deleteTaskNumber}<br>Was previously assigned to: ${originalModules.join(', ')}</small>`;
            
            resultDiv.style.backgroundColor = '#d4edda';
            resultDiv.style.color = '#155724';
            resultDiv.style.border = '1px solid #c3e6cb';
            resultDiv.style.display = 'block';
            
            // Clear the form
            document.getElementById('deleteTaskNumber').value = '';
            document.getElementById('deleteMallId').value = '';
            document.getElementById('deleteShopNo').value = '';
            
            // Hide result after 5 seconds
            setTimeout(() => {
                resultDiv.style.display = 'none';
            }, 5000);
        }

        // Add enter key support and click outside to close
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('mallSearch');
            const resultsDiv = document.getElementById('searchResults');
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchMall();
                }
            });

            // Close results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container')) {
                    resultsDiv.classList.remove('show');
                }
            });
        });

        // Toggle collapse functionality for inactive modules
        function toggleCollapse(header) {
            const mainGroup = header.parentElement;
            const content = mainGroup.querySelector('.collapsible-content');
            const workItems = content.querySelectorAll('.subgroup');
            
            mainGroup.classList.toggle('collapsed');
            
            // Add scroll functionality for modules with many items (more than 10)
            if (!mainGroup.classList.contains('collapsed') && workItems.length > 10) {
                content.classList.add('expanded');
            } else {
                content.classList.remove('expanded');
            }
        }

        // Update all work items with titles on page load
        document.addEventListener('DOMContentLoaded', function() {
            const workItems = document.querySelectorAll('.work-item');
            workItems.forEach(item => {
                const workCode = item.textContent.trim();
                if (workTitles[workCode]) {
                    item.innerHTML = createWorkItem(workCode);
                }
            });
        });

        // Add click handlers for groups (non-collapsible headers only)
        document.querySelectorAll('.subgroup').forEach(subgroup => {
            subgroup.addEventListener('click', function() {
                const groupName = this.querySelector('.subgroup-name').textContent;
                console.log('Selected group:', groupName);
                // Add your group selection logic here
            });
        });

        // Only add click handlers to non-collapsible headers
        document.querySelectorAll('.main-group-header:not(.collapsible-header)').forEach(header => {
            header.addEventListener('click', function() {
                const groupName = this.textContent.split('\n')[0].trim();
                console.log('Selected main group:', groupName);
                // Add your main group selection logic here
            });
        });

        // Function to populate Single Work section dynamically
        function populateSingleWork() {
            const allTaskCodes = Object.keys(workTitles).sort();
            const singleWorkContent = document.getElementById('single-work-content');
            const singleWorkCount = document.getElementById('single-work-count');
            
            if (!singleWorkContent || !singleWorkCount) {
                console.error('Single Work elements not found');
                return;
            }
            
            let html = '';
            allTaskCodes.forEach(taskCode => {
                html += `
                    <div class="subgroup">
                        <div class="subgroup-name work-item">${createWorkItem(taskCode)}</div>
                    </div>`;
            });
            
            singleWorkContent.innerHTML = html;
            singleWorkCount.textContent = allTaskCodes.length;
            
            console.log(`Populated Single Work with ${allTaskCodes.length} tasks`);
        }

        // Initialize Single Work section on page load
        document.addEventListener('DOMContentLoaded', function() {
            populateSingleWork();
        });
    </script>
</body>
</html>
