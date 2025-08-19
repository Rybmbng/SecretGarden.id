<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body style="font-family:Arial, sans-serif;background:#f4f6f8;padding:20px;">
  <div style="max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:8px;">
    <h3 style="color:#0d6efd">Reply from Admin</h3>
    <p>Hi <?= esc($name) ?>,</p>
    <div style="white-space:pre-line;line-height:1.6"><?= nl2br(esc($reply)) ?></div>
    <hr style="margin:20px 0;border:none;border-top:1px solid #eee;">
    <p style="font-size:13px;color:#666"><strong>Original message:</strong></p>
    <blockquote style="margin:0;padding-left:12px;border-left:4px solid #ddd;color:#555"><?= nl2br(esc($original)) ?></blockquote>
    <p style="margin-top:20px;">Regards,<br>Admin Team</p>
  </div>
</body></html>
