import { defineStore } from 'pinia';
import { ref  } from 'vue';

export const useProdukStore = defineStore('productStore', () => {
  const listProduk = ref([
    {
      id: 1,
      nama: 'Smartphone XYZ',
      deskripsi: 'High-quality smartphone with amazing features.',
      overview: 'High-quality smartphone with amazing features.',
      tags: ['smartphone', 'tech'],
      harga: 6990000,
      gambar: 'path/to/smartphone_xyz.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 2,
      nama: 'Laptop ABC',
      deskripsi: 'Powerful laptop for all your computing needs.',
      overview: 'Powerful laptop for all your computing needs.',
      tags: ['smartphone', 'gadget'],
      harga: 15990000,
      gambar: 'path/to/laptop_abc.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 3,
      nama: 'Wireless Headphones',
      deskripsi: 'Comfortable and high-quality sound wireless headphones.',
      overview: 'Comfortable and high-quality sound wireless headphones.',
      tags: ['smartphone', 'electronics'],
      harga: 1990000,
      gambar: 'path/to/wireless_headphones.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 4,
      nama: 'Smartwatch 2021',
      deskripsi: 'Track your fitness and stay connected.',
      overview: 'Track your fitness and stay connected.',
      tags: ['smartphone', 'electronics'],
      harga: 2990000,
      gambar: 'path/to/smartwatch_2021.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 5,
      nama: 'Gaming Console Pro',
      deskripsi: 'Next-gen gaming console with stunning graphics.',
      overview: 'Next-gen gaming console with stunning graphics.',
      tags: ['smartphone', 'electronics'],
      harga: 4999000,
      gambar: 'path/to/gaming_console_pro.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 6,
      nama: 'Tablet 2022',
      deskripsi: 'Lightweight tablet with a crystal-clear display.',
      overview: 'Lightweight tablet with a crystal-clear display.',
      tags: ['smartphone', 'gadget'],
      harga: 3990000,
      gambar: 'path/to/tablet_2022.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 7,
      nama: 'Bluetooth Speaker',
      deskripsi: 'Portable speaker with excellent sound quality.',
      overview: 'Portable speaker with excellent sound quality.',
      tags: ['smartphone', 'gadget'],
      harga: 1290000,
      gambar: 'path/to/bluetooth_speaker.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 8,
      nama: '4K TV',
      deskripsi: 'Ultra HD TV with vibrant colors and sharp details.',
      overview: 'Ultra HD TV with vibrant colors and sharp details.',
      tags: ['smartphone', 'electronics'],
      harga: 7999000,
      gambar: 'path/to/4k_tv.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 9,
      nama: 'Digital Camera',
      deskripsi: 'Capture stunning photos with this high-quality camera.',
      overview: 'Capture stunning photos with this high-quality camera.',
      tags: ['accessories', 'electronics'],
      harga: 2599000,
      gambar: 'path/to/digital_camera.jpg',
      sedang_dijual: true,
      pin: false,
    },
    {
      id: 10,
      nama: 'Smart Home Hub',
      deskripsi: 'Control your smart home devices with ease.',
      overview: 'Control your smart home devices with ease.',
      tags: ['smartphone', 'tech'],
      harga: 3490000,
      gambar: 'path/to/smart_home_hub.jpg',
      sedang_dijual: true,
      pin: false,
    },
  ]);

  const tags = ref(['smartphone', 'electronics', 'gadget', 'accessories', 'tech']);
  const listTagProduk = ref([]);


  const createProduk = product => {
    product.id = listProduk.value.length + 1;
    product.sedang_dijual = true;
    listProduk.value.push(product);
  };

  const readProduk = productId => {
    return listProduk.value.find(p => p.id === productId);
  };

  const updateProduk = (productId, updatedProduk) => {
    const index = listProduk.value.findIndex(p => p.id === productId);
    if (index !== -1) {
      listProduk.value[index] = { ...listProduk.value[index], ...updatedProduk };
    }
  };

  const deleteProduk = productId => {
    listProduk.value = listProduk.value.filter(p => p.id !== productId);
  };

  // Search and filter functions
  const searchProduk = ({ search, page, length, tags }) => {
    const filteredProduk = listProduk.value.filter(
      product =>
        product.nama.toLowerCase().includes(search.toLowerCase()) ||
        product.deskripsi.toLowerCase().includes(search.toLowerCase()),
    ).filter(product => {
      if (tags.length === 0) {
        return true;
      }
      
      return tags.every(tag => product.tags.includes(tag));
    })


  return {
      listProduk: filteredProduk.slice((page - 1) * length, page * length),
      pages: Math.ceil(filteredProduk.length / length),
    } 

  };

  // Generate WhatsApp link
  const generateWhatsAppLink = productName => {
    const phoneNumber = '1234567890'; // Replace with actual phone number
    
return `https://api.whatsapp.com/send?phone=${phoneNumber}&text=Saya%20ingin%20membeli%20${encodeURIComponent(
      productName,
    )}`;
  };

  return {
    listProduk,
    tags,
    listTagProduk,
    createProduk,
    readProduk,
    updateProduk,
    deleteProduk,
    searchProduk,
    generateWhatsAppLink,
  };
});
