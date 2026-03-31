<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Registry System - General Fund</title>
    <style>
        :root {
            --primary-blue: #3498db;
            --dark-blue: #2c3e50;
            --success-green: #27ae60;
            --purple: #9b59b6;
            --red: #e74c3c;
            --orange: #e67e22;
            --bg-gray: #f4f7f6;
            --subtotal-bg: #ebf5fb;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-gray); margin: 0; padding: 20px; display: flex; justify-content: center; }
        .container { width: 100%; max-width: 1400px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; }

        .fund-selector-container { margin-bottom: 20px; text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 15px; }
        .btn-opt { padding: 10px 20px; border: 2px solid var(--dark-blue); background: white; cursor: pointer; border-radius: 4px; font-weight: bold; margin: 0 5px; transition: 0.3s; }
        .active-fund-btn { background: var(--dark-blue) !important; color: white !important; }

        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--primary-blue); padding-bottom: 10px; margin-bottom: 20px; }
        .nav-buttons { display: flex; gap: 10px; }
        .nav-buttons button { padding: 12px 18px; border: none; border-radius: 4px; color: white; cursor: pointer; font-weight: bold; font-size: 0.85em; }

        .btn-purple { background-color: var(--purple) !important; }
        .btn-blue { background-color: var(--primary-blue) !important; }
        .btn-orange { background-color: var(--orange) !important; }
        .btn-green { background-color: var(--success-green) !important; }
        
        /* DASHBOARD STYLES */
        .dashboard-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            gap: 15px;
        }
        .stat-card { text-align: center; width: 140px; }
        .circle-container { width: 90px; margin: 0 auto 10px; }
        .circular-chart { display: block; max-height: 90px; }
        .circle-bg { fill: none; stroke: #eee; stroke-width: 3.8; }
        .circle { fill: none; stroke-width: 2.8; stroke-linecap: round; transition: stroke-dasharray 0.6s ease; }
        .percentage { fill: #333; font-family: sans-serif; font-size: 0.55em; text-anchor: middle; font-weight: bold; }
        
        /* Circle Colors */
        .blue .circle { stroke: var(--primary-blue); }
        .orange .circle { stroke: var(--orange); }
        .purple .circle { stroke: var(--purple); }
        .green .circle { stroke: var(--success-green); }
        .red .circle { stroke: var(--red); }

        .stat-label { font-size: 0.75em; font-weight: bold; color: var(--dark-blue); text-transform: uppercase; }

        .batch-action-bar { 
            background: #2c3e50; color: white; padding: 15px; border-radius: 4px; 
            margin-bottom: 15px; display: none; align-items: center; gap: 15px;
            position: sticky; top: 10px; z-index: 100; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .status-badge { padding: 4px 8px; border-radius: 4px; color: white; font-weight: bold; font-size: 0.8em; display: inline-block; text-align: center; min-width: 110px; }
        .status-advice { background-color: var(--primary-blue); }
        .status-mayor { background-color: var(--orange); }
        .status-sb { background-color: var(--purple); }
        .status-released { background-color: var(--success-green); }
        .status-cancelled { background-color: var(--red); }

        .entry-form { background: #fff; padding: 25px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; }
        .input-group { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .input-field label { display: block; font-size: 0.85em; color: #555; margin-bottom: 5px; font-weight: bold; }
        .input-field input, .input-field select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-save { width: 100%; padding: 15px; background-color: var(--success-green); color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; text-transform: uppercase; margin-top: 15px; }

        .search-container { margin-bottom: 15px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        #searchInput { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9em; box-sizing: border-box; }
        #searchInput:focus { border-color: var(--primary-blue); outline: none; box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 10px; font-size: 0.9em; text-align: left; border-bottom: 1px solid #eee; color: #333; }
        th { background-color: var(--dark-blue); color: white; text-transform: uppercase; }
        
        .col-date { white-space: nowrap; width: 110px; }
        .col-check { white-space: nowrap; width: 100px; }
        .col-amount { white-space: nowrap; width: 140px; text-align: right; }
        .col-select { width: 30px; text-align: center; }
        
        .subtotal-row { background-color: var(--subtotal-bg); font-weight: bold; color: var(--dark-blue); }
        .grand-total-row { background-color: #d5dbdb; font-weight: 900; color: black; border-top: 2px solid black; }
        
        .actions-cell-container { display: flex; gap: 5px; flex-wrap: nowrap; }
        .btn-edit { background-color: #f1c40f; color: black; border: none; padding: 6px 12px; border-radius: 3px; cursor: pointer; font-weight: bold; }
        .btn-delete { background-color: var(--red); color: white; border: none; padding: 6px 12px; border-radius: 3px; cursor: pointer; font-weight: bold; }

        @media print {
            @page { size: 8.5in 13in; margin: 0.5in; }
            .no-print, .actions-cell, .status-cell, .entry-form, .header, .fund-selector-container, .col-select, .batch-action-bar, .search-container, .dashboard-container { display: none !important; }
            .col-particulars { display: none !important; }
            body { padding: 0; background: white; width: 100%; }
            .container { width: 100%; max-width: 100%; box-shadow: none; padding: 0; }
            table { width: 100% !important; border: 1px solid black; table-layout: fixed; }
            th, td { border: 1px solid black !important; padding: 8px !important; font-size: 11pt !important; overflow: hidden; word-wrap: break-word; }
            .col-date { width: 15% !important; }
            .col-check { width: 15% !important; }
            .col-payee { width: 50% !important; }
            .col-amount { text-align: right !important; width: 20% !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
            .signature-section { display: flex !important; flex-direction: row; justify-content: space-between; margin-top: 100px; page-break-inside: avoid; }
            .sig-box { width: 40%; }
            .sig-line { border-top: 1.5px solid black; margin-top: 45px; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 12pt; padding-top: 5px; min-height: 25px; }
            .hide-on-print { display: none !important; }
        }
        .print-header, .signature-section { display: none; }
    </style>
</head>
<body onload="initSystem()">

<div class="container">
    <div class="fund-selector-container no-print">
        <div id="fundOptions">
            <button class="btn-opt" id="btn-GENERAL" onclick="selectFund('GENERAL FUND')">GENERAL FUND</button>
            <button class="btn-opt" id="btn-FUND14" onclick="selectFund('TRUST FUND - 14')">TRUST FUND - 14</button>
            <button class="btn-opt" id="btn-FUND16" onclick="selectFund('TRUST FUND - 16')">TRUST FUND - 16</button>
            <button class="btn-opt" id="btn-SEF" onclick="selectFund('SEF')">SEF</button>
        </div>
        <h3 id="currentFundDisplay" style="margin-top: 15px; color: var(--primary-blue); font-weight: 800;">CURRENT FUND: GENERAL FUND</h3>
    </div>

    <div class="print-header">
        <h1 id="reportTitle" style="text-transform: uppercase; margin:0; font-size: 16pt;">MONTHLY REPORT</h1>
        <h2 id="printFundName" style="margin:5px 0;"></h2>
        <p id="reportPeriod" style="font-weight:bold;"></p>
    </div>
    
    <div class="header no-print">
        <h2 id="viewTitle" style="color: var(--dark-blue); margin: 0; font-weight: 800;">Registry Main</h2>
        <div class="nav-buttons">
            <button id="excelBtn" class="btn-blue" style="display:none;" onclick="exportToExcel()">EXPORT EXCEL</button>
            <button id="monthlyReportBtn" class="btn-green" style="display:none;" onclick="generateMonthlyReport()">MONTHLY REPORT</button>
            <button class="btn-green" onclick="window.location.href='http://ice-server/home/homepage.php'">HOME</button>
            <button class="btn-orange" onclick="prepareTransmittal()">PRINT TRANSMITTAL</button>
            <button id="relBtn" class="btn-purple" onclick="setMode('released')">RELEASED / CANCELLED</button>
            <button id="regBtn" class="btn-blue" style="display:none;" onclick="setMode('registry')">MAIN REGISTRY</button>
        </div>
    </div>

    <div class="dashboard-container no-print">
        <div class="stat-card">
            <div class="circle-container">
                <svg viewBox="0 0 36 36" class="circular-chart blue">
                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="percent-advice" class="circle" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" id="text-advice">0%</text>
                </svg>
            </div>
            <div class="stat-label">FOR ADVICE</div>
        </div>
        <div class="stat-card">
            <div class="circle-container">
                <svg viewBox="0 0 36 36" class="circular-chart orange">
                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="percent-mayor" class="circle" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" id="text-mayor">0%</text>
                </svg>
            </div>
            <div class="stat-label">MAYOR'S OFFICE</div>
        </div>
        <div class="stat-card">
            <div class="circle-container">
                <svg viewBox="0 0 36 36" class="circular-chart purple">
                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="percent-sb" class="circle" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" id="text-sb">0%</text>
                </svg>
            </div>
            <div class="stat-label">SB OFFICE</div>
        </div>
        <div class="stat-card">
            <div class="circle-container">
                <svg viewBox="0 0 36 36" class="circular-chart green">
                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="percent-released" class="circle" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" id="text-released">0%</text>
                </svg>
            </div>
            <div class="stat-label">RELEASED</div>
        </div>
        <div class="stat-card">
            <div class="circle-container">
                <svg viewBox="0 0 36 36" class="circular-chart red">
                    <path class="circle-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path id="percent-cancelled" class="circle" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20.35" class="percentage" id="text-cancelled">0%</text>
                </svg>
            </div>
            <div class="stat-label">CANCELLED</div>
        </div>
    </div>

    <div id="batchBar" class="batch-action-bar no-print">
        <span id="selectedCount">0 items selected</span>
        <select id="batchStatus" style="padding: 8px; border-radius: 4px;">
            <option value="FOR ADVICE">FOR ADVICE</option>
            <option value="MAYOR'S OFFICE">MAYOR'S OFFICE</option>
            <option value="SB OFFICE">SB OFFICE</option>
            <option value="RELEASED">RELEASED</option>
            <option value="CANCELLED">CANCELLED</option>
        </select>
        <button onclick="applyBatchUpdate()" style="background: var(--success-green); color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">UPDATE SELECTED</button>
        <button onclick="toggleAll(false)" style="background: transparent; color: white; border: 1px solid white; padding: 10px 20px; border-radius: 4px; cursor: pointer;">CANCEL</button>
    </div>

    <div class="entry-form no-print" id="entryForm">
        <input type="hidden" id="editId" value="">
        <div class="input-group">
            <div class="input-field"><label>Date Issued</label><input type="date" id="date"></div>
            <div class="input-field">
                <label>Check #</label>
                <input type="number" id="checkNo" placeholder="Numbers only" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="input-field">
                <label>Payee Name</label>
                <input type="text" id="payee" list="payeeList" autocomplete="off">
                <datalist id="payeeList"></datalist>
            </div>
            <div class="input-field">
                <label>Particulars</label>
                <input type="text" id="particulars" list="particularsList" autocomplete="off">
                <datalist id="particularsList"></datalist>
            </div>
            <div class="input-field"><label>Amount</label><input type="number" id="amount" step="0.01"></div>
            <div class="input-field">
                <label>Status</label>
                <select id="status">
                    <option value="FOR ADVICE">FOR ADVICE</option>
                    <option value="MAYOR'S OFFICE">MAYOR'S OFFICE</option>
                    <option value="SB OFFICE">SB OFFICE</option>
                    <option value="RELEASED">RELEASED</option>
                    <option value="CANCELLED">CANCELLED</option>
                </select>
            </div>
        </div>
        <button class="btn-save" id="submitBtn" onclick="saveEntry()">Save Entry</button>
    </div>

    <div class="search-container no-print">
        <input type="text" id="searchInput" placeholder="🔍 Search Registry..." onkeyup="renderTable()">
    </div>

    <table id="registryTable">
        <thead>
            <tr>
                <th class="col-select no-print"><input type="checkbox" id="selectAll" onclick="toggleAll(this.checked)"></th>
                <th class="col-date">Date</th>
                <th class="col-check">Check #</th>
                <th class="col-payee">Payee</th>
                <th class="col-particulars">Particulars</th>
                <th class="col-amount">Amount</th>
                <th class="status-cell no-print">Status</th>
                <th class="actions-cell no-print">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>

    <div id="sigArea" class="signature-section">
        <div class="sig-box sig-prepared">
            <p>Prepared By:</p>
            <div class="sig-line">ADOLFO VALENZUELA</div>
        </div>
        <div class="sig-box sig-received">
            <p id="revLabel">Verified By:</p>
            <div class="sig-line" id="revName">ALJUN B. DELA CRUZ</div>
            <div id="revPos" style="text-align:center;">MUNICIPAL TREASURER</div>
            <div id="dateRecSection" style="display:none;"><p>DATE RECEIVED: ___________________</p></div>
        </div>
    </div>
</div>

<script>
    let currentFund = "GENERAL FUND";
    let viewMode = "registry";
    let isTransmittalMode = false; 
    let allData = [];

    function initSystem() { 
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').value = today;
        selectFund(localStorage.getItem('lastFund') || "GENERAL FUND"); 
    }

    function selectFund(name) {
        currentFund = name;
        localStorage.setItem('lastFund', name);
        document.getElementById('currentFundDisplay').innerText = `CURRENT FUND: ${name}`;
        document.getElementById('printFundName').innerText = name;
        document.querySelectorAll('.btn-opt').forEach(btn => btn.classList.remove('active-fund-btn'));
        const activeBtn = Array.from(document.querySelectorAll('.btn-opt')).find(b => b.innerText === name);
        if(activeBtn) activeBtn.classList.add('active-fund-btn');
        renderTable();
    }

    function setMode(mode) {
        viewMode = mode;
        const isReleased = mode === 'released';
        document.getElementById('viewTitle').innerText = isReleased ? "Released / Cancelled Checks" : "Registry Main";
        document.getElementById('entryForm').style.display = isReleased ? 'none' : 'block';
        document.getElementById('relBtn').style.display = isReleased ? 'none' : 'block';
        document.getElementById('regBtn').style.display = isReleased ? 'block' : 'none';
        document.getElementById('monthlyReportBtn').style.display = isReleased ? 'block' : 'none';
        document.getElementById('excelBtn').style.display = isReleased ? 'block' : 'none';
        toggleAll(false);
        renderTable();
    }

    function updateDatalists() {
        const pList = document.getElementById('payeeList');
        const partList = document.getElementById('particularsList');
        pList.innerHTML = ""; partList.innerHTML = "";
        const uniquePayees = [...new Set(allData.map(i => i.payee))];
        const uniqueParts = [...new Set(allData.map(i => i.particulars))];
        uniquePayees.sort().forEach(p => p && (pList.innerHTML += `<option value="${p}">`));
        uniqueParts.sort().forEach(p => p && (partList.innerHTML += `<option value="${p}">`));
    }

    function toggleAll(checked) {
        const checkboxes = document.querySelectorAll('.row-select');
        checkboxes.forEach(cb => cb.checked = checked);
        updateBatchBar();
    }

    function updateBatchBar() {
        const selected = document.querySelectorAll('.row-select:checked');
        const bar = document.getElementById('batchBar');
        const count = document.getElementById('selectedCount');
        if (selected.length > 0) {
            bar.style.display = 'flex';
            count.innerText = `${selected.length} items selected`;
        } else {
            bar.style.display = 'none';
            document.getElementById('selectAll').checked = false;
        }
    }

    // DASHBOARD UPDATE LOGIC (NOW INCLUDES CANCELLED)
    function updateDashboard(data) {
        const total = data.length;
        if (total === 0) {
            resetDashboard();
            return;
        }

        const counts = { 'FOR ADVICE': 0, "MAYOR'S OFFICE": 0, 'SB OFFICE': 0, 'RELEASED': 0, 'CANCELLED': 0 };
        data.forEach(item => { if (counts.hasOwnProperty(item.status)) counts[item.status]++; });

        updateCircle('advice', (counts['FOR ADVICE'] / total) * 100);
        updateCircle('mayor', (counts["MAYOR'S OFFICE"] / total) * 100);
        updateCircle('sb', (counts['SB OFFICE'] / total) * 100);
        updateCircle('released', (counts['RELEASED'] / total) * 100);
        updateCircle('cancelled', (counts['CANCELLED'] / total) * 100);
    }

    function updateCircle(id, percentage) {
        const circle = document.getElementById(`percent-${id}`);
        const text = document.getElementById(`text-${id}`);
        const rounded = Math.round(percentage);
        circle.setAttribute("stroke-dasharray", `${rounded}, 100`);
        text.textContent = `${rounded}%`;
    }

    function resetDashboard() {
        ['advice', 'mayor', 'sb', 'released', 'cancelled'].forEach(id => updateCircle(id, 0));
    }

    async function applyBatchUpdate() {
        const selected = document.querySelectorAll('.row-select:checked');
        const newStatus = document.getElementById('batchStatus').value;
        const ids = Array.from(selected).map(cb => cb.value);
        if (confirm(`Update ${ids.length} checks to ${newStatus}?`)) {
            for (let id of ids) {
                const item = allData.find(i => i.id == id);
                const data = {
                    id: item.id, fund: item.fund, date: item.date_issued,
                    check: item.check_no, payee: item.payee,
                    particulars: item.particulars, amount: item.amount,
                    status: newStatus
                };
                await fetch('api.php?action=save', { method: 'POST', body: JSON.stringify(data) });
            }
            toggleAll(false);
            renderTable();
        }
    }

    async function saveEntry() {
        const editId = document.getElementById('editId').value;
        const checkNoVal = document.getElementById('checkNo').value;
        if (!checkNoVal) { alert("INPUT A CHECK NUMBER!"); document.getElementById('checkNo').focus(); return; }

        const isDuplicate = allData.some(item => item.check_no == checkNoVal && item.fund == currentFund && item.id != editId);
        if (isDuplicate) { alert(`CHECK NUMBER ${checkNoVal} ALREADY EXISTS IN THIS FUND!`); document.getElementById('checkNo').focus(); return; }

        const data = {
            id: editId, fund: currentFund, date: document.getElementById('date').value, 
            check: checkNoVal,
            payee: document.getElementById('payee').value.toUpperCase(),
            particulars: document.getElementById('particulars').value.toUpperCase(),
            amount: document.getElementById('amount').value,
            status: document.getElementById('status').value
        };
        await fetch('api.php?action=save', { method: 'POST', body: JSON.stringify(data) });
        resetForm();
        renderTable();
    }

    async function renderTable() {
        try {
            const res = await fetch(`api.php?action=fetch&fund=${encodeURIComponent(currentFund)}`);
            allData = await res.json();
            
            updateDashboard(allData);
            updateDatalists();
            
            const filter = document.getElementById('searchInput').value.toUpperCase();
            const filtered = allData.filter(item => {
                const isFinished = (item.status === 'RELEASED' || item.status === 'CANCELLED');
                const matchesView = viewMode === 'registry' ? !isFinished : isFinished;
                return matchesView && (item.payee.toUpperCase().includes(filter) || item.check_no.includes(filter));
            });
            renderTableData(filtered);
        } catch (e) { console.error("Data fetch failed", e); }
    }

    function renderTableData(data) {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        let dTotal = 0, grandTotal = 0, lastD = null, checkCount = 0;

        // --- OPTIMIZED DYNAMIC SORTING ---
if (viewMode === 'registry' && !isTransmittalMode) {
    // Primary Sort: Date Issued (Latest at the top)
    // Secondary Sort: Check Number (Highest within that date at the top)
    data.sort((a, b) => {
        const dateA = new Date(a.date_issued);
        const dateB = new Date(b.date_issued);
        
        if (dateB - dateA !== 0) {
            return dateB - dateA; 
        }
        return parseInt(b.check_no) - parseInt(a.check_no);
    });
} else {
    // Released, Cancelled, and Transmittal: Standard ascending order for audit
    data.sort((a, b) => parseInt(a.check_no) - parseInt(b.check_no));
}
// -----------------------------

        data.forEach((item, index) => {
            // Grouping logic for subtotals (Works best when sorted by date)
            if (lastD && lastD !== item.date_issued) { 
                if(!isTransmittalMode && viewMode === 'registry') appendSub(tbody, lastD, dTotal); 
                dTotal = 0; 
            }

            let statusClass = "status-advice";
            if(item.status === "MAYOR'S OFFICE") statusClass = "status-mayor";
            if(item.status === "SB OFFICE") statusClass = "status-sb";
            if(item.status === "RELEASED") statusClass = "status-released";
            if(item.status === "CANCELLED") statusClass = "status-cancelled";
            
            let displayAmt = parseFloat(item.amount);
            let displayPayee = item.payee;

            if (item.status === "CANCELLED") { 
                displayAmt = 0; 
                displayPayee = `<span style="color:red; font-weight:bold">CANCELLED</span>`; 
            } else { 
                dTotal += displayAmt; 
                grandTotal += displayAmt; 
                checkCount++; 
            }

            const row = tbody.insertRow();
            row.innerHTML = `
                <td class="col-select no-print"><input type="checkbox" class="row-select" value="${item.id}" onclick="updateBatchBar()"></td>
                <td class="col-date">${item.date_issued}</td>
                <td class="col-check">${item.check_no}</td>
                <td class="col-payee">${displayPayee}</td>
                <td class="col-particulars">${item.particulars}</td>
                <td class="col-amount" style="font-weight:bold">₱${displayAmt.toLocaleString(undefined,{minimumFractionDigits:2})}</td>
                <td class="status-cell no-print"><span class="status-badge ${statusClass}">${item.status}</span></td>
                <td class="actions-cell no-print">
                    <div class="actions-cell-container"><button class="btn-edit" onclick="editItem(${item.id})">EDIT</button><button class="btn-delete" onclick="deleteItem(${item.id})">DELETE</button></div>
                </td>`;

            lastD = item.date_issued;

            if (index === data.length - 1) { 
                if(!isTransmittalMode) {
                    // Only show Daily Subtotal in Registry mode to keep Released view clean
                    if(viewMode === 'registry') appendSub(tbody, item.date_issued, dTotal); 
                    appendGrand(tbody, grandTotal, checkCount); 
                }
            }
        });
    }

    function appendSub(tbody, date, amt) {
        const row = tbody.insertRow();
        row.className = "subtotal-row";
        row.innerHTML = `<td class="no-print"></td><td colspan="3" style="text-align:right; font-style:italic;">Daily Subtotal (${date}):</td><td class="col-particulars"></td><td colspan="3" style="border-top: 1px solid #333;">₱${amt.toLocaleString(undefined,{minimumFractionDigits:2})}</td>`;
    }

    function appendGrand(tbody, total, count) {
        const row = tbody.insertRow();
        row.className = "grand-total-row";
        row.innerHTML = `<td class="no-print"></td><td colspan="3" style="text-align:right;">TOTAL CHECKS: ${count} | GRAND TOTAL:</td><td class="col-particulars"></td><td colspan="3">₱${total.toLocaleString(undefined,{minimumFractionDigits:2})}</td>`;
    }

    function editItem(id) {
        const item = allData.find(i => i.id == id);
        setMode('registry');
        document.getElementById('editId').value = item.id;
        document.getElementById('date').value = item.date_issued;
        document.getElementById('checkNo').value = item.check_no;
        document.getElementById('payee').value = item.payee;
        document.getElementById('particulars').value = item.particulars;
        document.getElementById('amount').value = item.amount;
        document.getElementById('status').value = item.status;
        document.getElementById('submitBtn').innerText = "Update Entry";
        window.scrollTo(0,0);
    }

    async function deleteItem(id) { if(confirm("Permanently delete this check?")) { await fetch(`api.php?action=delete&id=${id}`); renderTable(); } }

    function resetForm() {
    document.getElementById('editId').value = "";
    document.getElementById('submitBtn').innerText = "Save Entry";
    // Clears fields but keeps the date current
    ["checkNo", "payee", "particulars", "amount"].forEach(id => document.getElementById(id).value = "");
    document.getElementById('date').value = new Date().toISOString().split('T')[0];
}

    function generateMonthlyReport() { 
        isTransmittalMode = false;
        const months = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
        const monthInput = prompt("Enter Month:", months[new Date().getMonth()]).toUpperCase();
        if (!monthInput || !months.includes(monthInput)) return;
        const yearInput = prompt("Enter Year:", new Date().getFullYear());
        
        const filtered = allData.filter(item => {
            const d = new Date(item.date_issued);
            return (item.status === 'RELEASED' || item.status === 'CANCELLED') && d.getMonth() === months.indexOf(monthInput) && d.getFullYear() == yearInput;
        });

        if (filtered.length === 0) { alert("No Released checks found."); return; }
        document.querySelector('.sig-prepared').classList.add('hide-on-print');
        document.querySelector('.sig-received').classList.add('hide-on-print');
        document.getElementById('reportPeriod').innerText = "PERIOD: " + monthInput + " " + yearInput;
        document.getElementById('reportTitle').innerText = "MONTHLY REPORT OF CHECKS ISSUED";
        renderTableData(filtered);
        window.print();
        setTimeout(() => {
            document.querySelector('.sig-prepared').classList.remove('hide-on-print');
            document.querySelector('.sig-received').classList.remove('hide-on-print');
            renderTable();
        }, 1000);
    }

    async function prepareTransmittal(){

    const selected = document.querySelectorAll(".row-select:checked");

    if(selected.length === 0){
        alert("PLEASE SELECT CHECKS FOR TRANSMITTAL");
        return;
    }

    const office = prompt("ENTER OFFICE (Example: MAYOR or SB):");
    if(!office) return;

    const preparer = prompt("ENTER NAME OF PREPARER:", "ADOLFO VALENZUELA");
    if(!preparer) return;

    const officeStatus = office.toUpperCase() + " OFFICE";

    const transDate = prompt(
        "Enter Date for Transmittal:",
        new Date().toLocaleDateString('en-US', {
            month:'long',
            day:'numeric',
            year:'numeric'
        })
    );

    if(!transDate) return;

    const ids = Array.from(selected).map(cb => cb.value);

    const filtered = allData.filter(item => ids.includes(String(item.id)));



    // UPDATE STATUS ONE TIME
    for(let id of ids){

        const item = allData.find(i => i.id == id);

        const data = {
            id:item.id,
            fund:item.fund,
            date:item.date_issued,
            check:item.check_no,
            payee:item.payee,
            particulars:item.particulars,
            amount:item.amount,
            status:officeStatus
        };

        await fetch("api.php?action=save",{
            method:"POST",
            body:JSON.stringify(data)
        });

    }



    // SET PREPARER NAME
    document.querySelector(".sig-prepared .sig-line").innerText = preparer.toUpperCase();



    // PRINT TRANSMITTAL
    isTransmittalMode = true;

    document.querySelector('.sig-prepared').classList.remove('hide-on-print');
    document.querySelector('.sig-received').classList.remove('hide-on-print');

    document.getElementById("revLabel").innerText = "RECEIVED BY:";
    document.getElementById("revName").style.color = "transparent";
    document.getElementById("revPos").style.display = "none";

    document.getElementById("reportPeriod").innerText = transDate;

    document.getElementById("reportTitle").innerText =
        "TRANSMITTAL OF CHECKS - " + office.toUpperCase();

    renderTableData(filtered);

    window.print();



    setTimeout(()=>{

        isTransmittalMode=false;

        document.getElementById("revName").style.color="inherit";
        document.getElementById("revPos").style.display="block";
        document.getElementById("revLabel").innerText="Verified By:";

        toggleAll(false);
        renderTable();

    },1000);

}

function exportToExcel() {
    const months = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
    const monthInput = prompt("Enter Month:", months[new Date().getMonth()]).toUpperCase();
    if (!monthInput || !months.includes(monthInput)) return;
    const yearInput = prompt("Enter Year:", new Date().getFullYear());

    // Filter for Released/Cancelled in the chosen month
    const filtered = allData.filter(item => {
        const d = new Date(item.date_issued);
        return (item.status === 'RELEASED' || item.status === 'CANCELLED') && 
               d.getMonth() === months.indexOf(monthInput) && 
               d.getFullYear() == yearInput;
    });

    if (filtered.length === 0) { alert("No data found."); return; }

    // Sort by Check Number (standard for reports)
    filtered.sort((a, b) => parseInt(a.check_no) - parseInt(b.check_no));

    let excelTemplate = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head><meta charset="UTF-8"><style>
            .header-text { font-family: 'Segoe UI'; font-size: 14pt; font-weight: bold; text-align: center; }
            .subtotal { background-color: #ebf5fb; font-style: italic; font-weight: bold; }
            .grand-total { background-color: #d5dbdb; font-weight: bold; }
            th { background-color: #2c3e50; color: #ffffff; }
        </style></head>
        <body>
            <div class="header-text">MONTHLY REPORT OF CHECKS ISSUED</div>
            <div class="header-text">${currentFund}</div>
            <div style="text-align:center; font-weight:bold;">PERIOD: ${monthInput} ${yearInput}</div><br>
            <table border="1">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check #</th>
                        <th>Payee</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>`;

    let dTotal = 0;
    let grandTotal = 0;
    let lastDate = null;

    filtered.forEach((item, index) => {
        // Daily Subtotal logic (if date changes)
        if (lastDate && lastDate !== item.date_issued) {
            excelTemplate += `
                <tr class="subtotal">
                    <td colspan="4" align="right">Daily Subtotal (${lastDate}):</td>
                    <td>${dTotal.toFixed(2)}</td>
                </tr>`;
            dTotal = 0;
        }

        const amt = item.status === "CANCELLED" ? 0 : parseFloat(item.amount);
        const payeeText = item.status === "CANCELLED" ? "CANCELLED" : item.payee;
        
        dTotal += amt;
        grandTotal += amt;

        excelTemplate += `
            <tr>
                <td>${item.date_issued}</td>
                <td>${item.check_no}</td>
                <td>${payeeText}</td>
                <td>${item.particulars}</td>
                <td x:num="${amt.toFixed(2)}">${amt.toFixed(2)}</td>
            </tr>`;

        lastDate = item.date_issued;

        // Last row subtotals and Grand Total
        if (index === filtered.length - 1) {
            excelTemplate += `
                <tr class="subtotal">
                    <td colspan="4" align="right">Daily Subtotal (${item.date_issued}):</td>
                    <td>${dTotal.toFixed(2)}</td>
                </tr>
                <tr class="grand-total">
                    <td colspan="4" align="right">GRAND TOTAL:</td>
                    <td>${grandTotal.toFixed(2)}</td>
                </tr>`;
        }
    });

   
    const blob = new Blob([excelTemplate], { type: 'application/vnd.ms-excel' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `Report_${currentFund}_${monthInput}.xls`;
    a.click();
}
// SUBTOTAL ROW
function appendSub(tbody, date, amt) {
    const row = tbody.insertRow();
    row.className = "subtotal-row no-print"; // Added no-print so it doesn't show on reports
    row.innerHTML = `
        <td class="col-select">
            <input type="checkbox" class="date-group-checkbox" data-date="${date}" onclick="toggleDateGroup('${date}', this.checked)">
        </td>
        <td colspan="3" style="text-align:right; font-style:italic;">Daily Subtotal (${date}):</td>
        <td class="col-particulars"></td>
        <td colspan="3" style="border-top: 1.5px solid #333; font-weight: 800;">
            ₱${amt.toLocaleString(undefined, {minimumFractionDigits:2})}
        </td>`;
}

// GRAND TOTAL ROW
function appendGrandTotal(tbody, total, count){
    const tr = document.createElement("tr");
    tr.className = "grand-total-row";

    tr.innerHTML = `
        <td colspan="3">TOTAL CHECKS: ${count}</td>
        <td colspan="2">GRAND TOTAL</td>
        <td class="col-amount">${total.toLocaleString('en-US',{minimumFractionDigits:2})}</td>
        <td colspan="2"></td>
    `;

    tbody.appendChild(tr);
}


// RESET FORM AFTER SAVE
function resetForm(){
    document.getElementById("editId").value="";
    document.getElementById("payee").value="";
    document.getElementById("particulars").value="";
    document.getElementById("amount").value="";
    document.getElementById("checkNo").value="";
}


// EDIT ENTRY
function editEntry(id){

    const item = allData.find(i=>i.id==id);

    document.getElementById("editId").value = item.id;
    document.getElementById("date").value = item.date_issued;
    document.getElementById("checkNo").value = item.check_no;
    document.getElementById("payee").value = item.payee;
    document.getElementById("particulars").value = item.particulars;
    document.getElementById("amount").value = item.amount;
    document.getElementById("status").value = item.status;

    window.scrollTo({top:0, behavior:"smooth"});
}


// UPDATED: DELETE ITEM WITH PASSWORD PROTECTION
async function deleteItem(id) {
    const password = prompt("Enter administrative password to delete this check:");
    
    if (password === null) return; // User cancelled the prompt

    if (password === "dolpaxx_") {
        if (confirm("Permanently delete this check? This action cannot be undone.")) {
            await fetch(`api.php?action=delete&id=${id}`);
            renderTable();
        }
    } else {
        alert("INCORRECT PASSWORD. Access Denied.");
    }
}

// UPDATED: DELETE ENTRY WITH PASSWORD PROTECTION (Alternative function name in your code)
async function deleteEntry(id) {
    const password = prompt("Enter administrative password to delete this entry:");
    
    if (password === null) return;

    if (password === "dolpaxx_") {
        if (confirm("Delete this entry?")) {
            await fetch("api.php?action=delete&id=" + id);
            renderTable();
        }
    } else {
        alert("INCORRECT PASSWORD. Access Denied.");
    }
}

function goHome() {
    window.location.href = 'http://ice-server/home/homepage.php';
}

function toggleDateGroup(date, isChecked) {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(row => {
        // Find the date cell (2nd column)
        const dateCell = row.cells[1];
        if (dateCell && dateCell.innerText === date) {
            const cb = row.querySelector('.row-select');
            if (cb) {
                cb.checked = isChecked;
            }
        }
    });
    updateBatchBar();
}

</script>

</body>
</html>