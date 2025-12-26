<?= $this->include('adminpartial/header') ?>

<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10">
  <h2 class="text-3xl font-bold mb-6">Add New Slider</h2>
  <form id="sliderForm" class="space-y-6">
    <div>
      <label class="block text-sm font-medium">Desktop Slide</label>
      <input type="file" id="fileD" accept="image/*,video/*" required class="mt-2 w-full"/>
    </div>
    <div>
      <label class="block text-sm font-medium">Mobile Slide</label>
      <input type="file" id="fileM" accept="image/*,video/*" required class="mt-2 w-full"/>
    </div>

    <div id="progressModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl p-6 w-96 space-y-4">
        <h3 class="text-xl font-bold">Upload / Compress Progress</h3>
        <div id="progressList" class="space-y-2 max-h-64 overflow-y-auto"></div>
        <button type="button" id="minimizeBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Minimize</button>
      </div>
    </div>

    <input type="text" id="alt" placeholder="Alt Text" class="w-full border rounded-lg p-2"/>
    <input type="number" id="duration" placeholder="Duration (ms)" value="5000" class="w-full border rounded-lg p-2"/>

    <div class="flex justify-end">
      <a href="<?= base_url('/admin/page/home/slider') ?>" class="px-5 py-2 rounded-full bg-gray-200 hover:bg-gray-300 mr-3">Close</a>
      <button type="submit" class="px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700">Upload</button>
    </div>
  </form>
</div>

<div id="toastContainer" class="fixed bottom-5 right-5 space-y-2 z-50"></div>

<script>
const CHUNK_SIZE = 5*1024*1024;
const fileD = document.getElementById('fileD');
const fileM = document.getElementById('fileM');
const progressModal = document.getElementById('progressModal');
const progressList = document.getElementById('progressList');
const minimizeBtn = document.getElementById('minimizeBtn');
const toastContainer = document.getElementById('toastContainer');

function showToast(msg,type='success'){
    const div = document.createElement('div');
    div.className=`px-4 py-2 rounded shadow ${type==='success'?'bg-green-500 text-white':'bg-red-500 text-white'}`;
    div.textContent=msg;
    toastContainer.appendChild(div);
    setTimeout(()=>div.remove(),4000);
}

function safeFileName(file){
    const ext = file.name.split('.').pop();
    return 'upload_' + Date.now() + '_' + Math.floor(Math.random()*1000) + '.' + ext;
}

function createProgressCard(file,target){
    const card = document.createElement('div');
    card.className="border rounded p-2 space-y-1";

    const title = document.createElement('div'); title.textContent=`${file.name} (${target})`;
    const type = document.createElement('div'); type.className="text-sm text-gray-500"; type.textContent="Uploading...";
    const barWrapper = document.createElement('div'); barWrapper.className="w-full bg-gray-200 h-4 rounded";
    const bar = document.createElement('div'); bar.className="bg-blue-600 h-4 w-0 rounded"; barWrapper.appendChild(bar);
    const status = document.createElement('div'); status.className="text-sm text-gray-700"; status.textContent=`0 MB / ${(file.size/1024/1024).toFixed(2)} MB`;

    card.appendChild(title); card.appendChild(type); card.appendChild(barWrapper); card.appendChild(status);
    progressList.appendChild(card);

    return {bar,status,type};
}

async function uploadFile(file,target,safeName,progressEl){
    const totalChunks = Math.ceil(file.size/CHUNK_SIZE);
    let uploaded = 0;
    for(let i=0;i<totalChunks;i++){
        const chunk = file.slice(i*CHUNK_SIZE,(i+1)*CHUNK_SIZE);
        const fd = new FormData();
        fd.append("chunk",chunk);
        fd.append("target",target);
        fd.append("fileName",safeName);
        fd.append("chunkIndex",i);
        fd.append("totalChunks",totalChunks);

        try{
            const res = await fetch("<?= base_url('admin/page/home/slider/uploadChunk') ?>",{method:"POST",body:fd});
            if(!res.ok) throw new Error(`HTTP ${res.status}`);
        }catch(e){
            showToast(`Upload failed: ${e.message}`,'error'); throw e;
        }

        uploaded += chunk.size;
        const perc = Math.round(uploaded/file.size*100);
        progressEl.bar.style.width = perc + '%';
        progressEl.status.textContent=`${(uploaded/1024/1024).toFixed(2)} MB / ${(file.size/1024/1024).toFixed(2)} MB`;
    }
}

async function pollCompress(target,file,progressEl){
    progressEl.type.textContent="Compressing...";
    while(true){
        const res = await fetch(`<?= base_url('admin/page/home/slider/pollCompress') ?>/${target}/${encodeURIComponent(file)}`);
        const data = await res.json();

        if(data.progress !== undefined){
            progressEl.bar.style.width = data.progress + '%';
            progressEl.status.textContent = `Compress: ${data.progress}%`;
        }

        if(data.status==='done'){ 
            progressEl.type.textContent="Done"; 
            progressEl.status.textContent="100%";
            showToast(`${target} compress done`); 
            break;
        }
        else if(data.status==='error'){ 
            progressEl.type.textContent="Error"; 
            showToast(`${target} compress error`,'error'); 
            break;
        }

        await new Promise(r=>setTimeout(r,1000));
    }
}

async function startUpload(){
    const desktop = fileD.files[0];
    const mobile = fileM.files[0];
    if(!desktop || !mobile){ showToast('Select both files','error'); return; }

    const desktopSafeName = safeFileName(desktop);
    const mobileSafeName  = safeFileName(mobile);

    const alt = document.getElementById('alt').value;
    const duration = document.getElementById('duration').value;

    progressList.innerHTML='';
    progressModal.classList.remove('hidden');

    const desktopEl = createProgressCard(desktop,'Desktop');
    const mobileEl  = createProgressCard(mobile,'Mobile');

    try{
        await uploadFile(desktop,'desktop',desktopSafeName,desktopEl);
        await uploadFile(mobile,'mobile',mobileSafeName,mobileEl);
    }catch(e){ return; }

    let json;
    try{
        const res = await fetch("<?= base_url('admin/page/home/slider/finalizeUpload') ?>",{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({
                desktop:desktopSafeName,
                mobile:mobileSafeName,
                alt,duration
            })
        });
        json = await res.json();
        if(res.status!==200 || !json.files || !json.files.desktop){
            showToast('Finalize upload failed','error'); console.error(json); return;
        }
    }catch(e){ showToast('Finalize upload failed','error'); console.error(e); return; }

    await Promise.all([
        pollCompress('desktop', json.files.desktop, desktopEl),
        pollCompress('mobile', json.files.mobile, mobileEl)
    ]);

    showToast('Slider uploaded successfully!');
    setTimeout(()=>window.location.href='<?= base_url('admin/page/home/slider') ?>',1000);
}

minimizeBtn.addEventListener('click',()=>progressModal.classList.add('hidden'));
document.getElementById('sliderForm').addEventListener('submit',e=>{ e.preventDefault(); startUpload(); });
</script>


<?= view('adminpartial/footer') ?>
