#!/bin/bash
# =====================================
# Security Scan with Psalm
# Generate HTML & JSON reports
# =====================================

# Pastikan psalm sudah terinstall via composer
if [ ! -f "vendor/bin/psalm" ]; then
  echo "⚠️  Psalm belum diinstall. Jalankan: composer require --dev vimeo/psalm"
  exit 1
fi

# Folder report
REPORT_DIR="security-reports"
mkdir -p $REPORT_DIR

# Nama file berdasarkan timestamp
DATE=$(date +"%Y-%m-%d_%H-%M-%S")
HTML_REPORT="$REPORT_DIR/report_$DATE.html"
JSON_REPORT="$REPORT_DIR/report_$DATE.json"

echo "🔎 Menjalankan scan security dengan Psalm..."
echo "📂 Hasil akan disimpan di: $HTML_REPORT dan $JSON_REPORT"

# Jalankan psalm dengan taint analysis
vendor/bin/psalm --taint-analysis --report=$HTML_REPORT --output-format=html
vendor/bin/psalm --taint-analysis --report=$JSON_REPORT --output-format=json

echo "✅ Scan selesai!"
echo "🌐 Buka report di browser: $HTML_REPORT"

