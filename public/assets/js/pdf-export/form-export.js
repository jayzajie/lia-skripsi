/**
 * Form export functionality for SD Normal Islam 2 Samarinda
 * Handles form data export to PDF and printing
 */

// Initialize jsPDF
if (typeof window.jspdf === 'undefined') {
  window.jsPDF = window.jspdf.jsPDF;
}

class FormManager {
  constructor(formId) {
    this.form = document.getElementById(formId);
    this.dataKey = 'formulirData';
    this.finalizedKey = 'formulirFinalized';
    
    if (!this.form) return;
    
    // Initialize elements
    this.cetakBtn = document.getElementById('cetakBtn');
    this.exportPdfBtn = document.getElementById('exportPdfBtn');
    this.simpanBtn = document.getElementById('simpanBtn');
    this.successAlert = document.getElementById('successAlert');
    this.confirmModal = document.getElementById('confirmModal');
    this.confirmSaveBtn = document.getElementById('confirmSaveBtn');
    this.cancelSaveBtn = document.getElementById('cancelSaveBtn');
    this.formFinalizedBanner = document.getElementById('formFinalizedBanner');
    this.editFormBtn = document.getElementById('editFormBtn');
    
    this.init();
  }
  
  init() {
    // Check if form is finalized first
    this.checkFormFinalized();
    
    // Load saved data
    this.loadFormData();
    
    // If no data exists, populate with sample data
    if (!localStorage.getItem(this.dataKey)) {
      this.populateWithSampleData();
    }
    
    // Set up event listeners
    this.setupEventListeners();
  }
  
  setupEventListeners() {
    // Form submission
    if (this.form && this.simpanBtn) {
      this.simpanBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Check form validity first
        if (this.form.checkValidity()) {
          if (this.confirmModal) {
            this.confirmModal.style.display = 'block';
          }
        } else {
          // Trigger HTML5 validation
          this.form.reportValidity();
        }
      });
    }
    
    // Confirm save button
    if (this.confirmSaveBtn) {
      this.confirmSaveBtn.addEventListener('click', () => {
        // Save form data
        this.saveFormData();
        
        // Mark form as finalized
        localStorage.setItem(this.finalizedKey, 'true');
        
        // Close modal
        if (this.confirmModal) {
          this.confirmModal.style.display = 'none';
        }
        
        // Disable form
        this.disableForm();
        
        // Show finalized banner
        this.showFinalizedBanner();
        
        // Show success message
        this.showSuccess('Data berhasil disimpan dan difinalisasi!');
      });
    }
    
    // Cancel save button
    if (this.cancelSaveBtn) {
      this.cancelSaveBtn.addEventListener('click', () => {
        if (this.confirmModal) {
          this.confirmModal.style.display = 'none';
        }
      });
    }
    
    // Close modal when clicking outside
    if (this.confirmModal) {
      window.addEventListener('click', (event) => {
        if (event.target == this.confirmModal) {
          this.confirmModal.style.display = 'none';
        }
      });
    }
    
    // Edit form button
    if (this.editFormBtn) {
      this.editFormBtn.addEventListener('click', () => {
        // Show confirmation dialog
        if (confirm('Apakah Anda yakin ingin mengedit formulir yang sudah difinalisasi?')) {
          // Enable form
          this.enableForm();
          
          // Hide finalized banner
          if (this.formFinalizedBanner) {
            this.formFinalizedBanner.style.display = 'none';
          }
          
          // Mark form as not finalized
          localStorage.setItem(this.finalizedKey, 'false');
        }
      });
    }
    
    // Print button
    if (this.cetakBtn) {
      this.cetakBtn.addEventListener('click', () => this.printForm());
    }
    
    // PDF export button
    if (this.exportPdfBtn) {
      this.exportPdfBtn.addEventListener('click', () => this.exportToPDF());
    }
    
    // Auto-save form data as user types (only if not finalized)
    if (!this.isFormFinalized()) {
      const formInputs = this.form.querySelectorAll('input, select, textarea');
      formInputs.forEach(input => {
        input.addEventListener('change', () => this.autoSaveFormData());
        
        if (input.type !== 'file') {
          input.addEventListener('input', () => this.autoSaveFormData());
        }
      });
    }
  }
  
  saveFormData() {
    if (!this.form) return;
    
    const formData = new FormData(this.form);
    const formObject = {};
    
    formData.forEach((value, key) => {
      // Only save non-empty values
      if (value !== '') {
        formObject[key] = value;
      }
    });
    
    // Save to localStorage
    localStorage.setItem(this.dataKey, JSON.stringify(formObject));
    
    // For debugging
    console.log('Data saved to localStorage:', formObject);
  }
  
  autoSaveFormData() {
    // Only auto-save if form is not finalized
    if (!this.isFormFinalized()) {
      this.saveFormData();
    }
  }
  
  loadFormData() {
    if (!this.form) return;
    
    const savedData = localStorage.getItem(this.dataKey);
    
    if (savedData) {
      try {
        const formObject = JSON.parse(savedData);
        
        // Log for debugging
        console.log('Loading data from localStorage:', formObject);
        
        for (const key in formObject) {
          const input = this.form.elements[key];
          if (input) {
            input.value = formObject[key];
          }
        }
      } catch (error) {
        console.error('Error parsing form data from localStorage:', error);
      }
    }
  }
  
  checkFormFinalized() {
    if (this.isFormFinalized()) {
      this.disableForm();
      this.showFinalizedBanner();
    }
  }
  
  isFormFinalized() {
    return localStorage.getItem(this.finalizedKey) === 'true';
  }
  
  disableForm() {
    if (!this.form) return;
    
    const formInputs = this.form.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
      input.setAttribute('disabled', 'disabled');
    });
    
    // Hide save button
    if (this.simpanBtn) {
      this.simpanBtn.style.display = 'none';
    }
  }
  
  enableForm() {
    if (!this.form) return;
    
    const formInputs = this.form.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
      input.removeAttribute('disabled');
    });
    
    // Show save button
    if (this.simpanBtn) {
      this.simpanBtn.style.display = 'inline-block';
    }
  }
  
  showFinalizedBanner() {
    if (this.formFinalizedBanner) {
      this.formFinalizedBanner.style.display = 'flex';
    }
  }
  
  showSuccess(message = 'Data berhasil disimpan!') {
    if (!this.successAlert) return;
    
    this.successAlert.textContent = message;
    this.successAlert.style.display = 'block';
    setTimeout(() => {
      this.successAlert.style.display = 'none';
    }, 3000);
  }
  
  printForm() {
    window.print();
  }
  
  exportToPDF() {
    // Initialize jsPDF if needed
    if (typeof window.jsPDF === 'undefined' && typeof window.jspdf !== 'undefined') {
      window.jsPDF = window.jspdf.jsPDF;
    }
    
    if (typeof window.jsPDF === 'undefined') {
      console.error('jsPDF is not loaded');
      alert('PDF export is not available at the moment. Please try again later.');
      return;
    }
    
    const formData = new FormData(this.form);
    const formObject = {};
    formData.forEach((value, key) => {
      formObject[key] = value;
    });
    
    // Field labels mapping
    const fieldLabels = {
      'nama': 'Nama Lengkap',
      'nik': 'NIK',
      'tempat_lahir': 'Tempat Lahir',
      'tanggal_lahir': 'Tanggal Lahir',
      'jenis_kelamin': 'Jenis Kelamin',
      'agama': 'Agama',
      'nama_ayah': 'Nama Ayah',
      'nama_ibu': 'Nama Ibu',
      'pekerjaan_ayah': 'Pekerjaan Ayah',
      'pekerjaan_ibu': 'Pekerjaan Ibu',
      'no_hp': 'No. HP',
      'email': 'Email',
      'alamat': 'Alamat Lengkap',
      'kecamatan': 'Kecamatan',
      'kota': 'Kota/Kabupaten',
      'provinsi': 'Provinsi'
    };
    
    // Create PDF
    const pdf = new jsPDF('p', 'mm', 'a4');
    
    // Add title
    pdf.setFontSize(16);
    pdf.text('FORMULIR PENDAFTARAN SISWA', 105, 20, { align: 'center' });
    pdf.text('SD NORMAL ISLAM 2 SAMARINDA', 105, 30, { align: 'center' });
    pdf.setLineWidth(0.5);
    pdf.line(20, 35, 190, 35);
    
    // Add finalized status if applicable
    if (this.isFormFinalized()) {
      pdf.setFontSize(12);
      pdf.setTextColor(0, 128, 0); // Green color
      pdf.text('Status: DIFINALISASI', 20, 42);
      pdf.setTextColor(0, 0, 0); // Reset to black
    }
    
    // Add sections
    pdf.setFontSize(12);
    
    // Data Pribadi section
    pdf.text('DATA PRIBADI', 20, 50);
    let y = 60;
    
    ['nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama'].forEach(key => {
      if (formObject[key]) {
        let value = formObject[key];
        
        // Format some values
        if (key === 'jenis_kelamin') {
          value = value === 'L' ? 'Laki-laki' : 'Perempuan';
        }
        if (key === 'agama') {
          const agamaMap = {
            'islam': 'Islam',
            'kristen': 'Kristen',
            'katolik': 'Katolik',
            'hindu': 'Hindu',
            'buddha': 'Buddha',
            'konghucu': 'Konghucu'
          };
          value = agamaMap[value] || value;
        }
        
        pdf.text(`${fieldLabels[key]}: ${value}`, 25, y);
        y += 10;
      }
    });
    
    // Data Orang Tua section
    pdf.text('DATA ORANG TUA', 20, y + 5);
    y += 15;
    
    ['nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'no_hp', 'email'].forEach(key => {
      if (formObject[key]) {
        pdf.text(`${fieldLabels[key]}: ${formObject[key]}`, 25, y);
        y += 10;
      }
    });
    
    // Alamat section
    pdf.text('ALAMAT', 20, y + 5);
    y += 15;
    
    ['alamat', 'kecamatan', 'kota', 'provinsi'].forEach(key => {
      if (formObject[key]) {
        pdf.text(`${fieldLabels[key]}: ${formObject[key]}`, 25, y);
        y += 10;
      }
    });
    
    // Add signature section
    y += 10;
    pdf.text('Samarinda, ................................', 120, y);
    y += 10;
    pdf.text('Orang Tua/Wali', 140, y);
    y += 30;
    pdf.text('(.................................................)', 130, y);
    
    // Save PDF
    pdf.save('Formulir_Pendaftaran_SD_Normal_Islam_2.pdf');
  }
  
  populateWithSampleData() {
    // Sample data for form fields
    const sampleData = {
      'nama': 'Andi Saputra',
      'nik': '6472050501100001',
      'tempat_lahir': 'Samarinda',
      'tanggal_lahir': '2016-05-15',
      'jenis_kelamin': 'L',
      'agama': 'islam',
      'nama_ayah': 'Budi Santoso',
      'nama_ibu': 'Siti Rahayu',
      'pekerjaan_ayah': 'Wiraswasta',
      'pekerjaan_ibu': 'Guru',
      'no_hp': '081234567890',
      'email': 'budi.santoso@example.com',
      'alamat': 'Jl. Perjuangan No. 45, RT 05/RW 02',
      'kecamatan': 'Samarinda Ulu',
      'kota': 'Samarinda',
      'provinsi': 'Kalimantan Timur'
    };
    
    // Save to localStorage
    localStorage.setItem(this.dataKey, JSON.stringify(sampleData));
    
    // Set form values
    if (this.form) {
      for (const key in sampleData) {
        const input = this.form.elements[key];
        if (input) {
          input.value = sampleData[key];
        }
      }
    }
  }
}

// Initialize form manager when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  const formManager = new FormManager('formulirPendaftaran');
}); 