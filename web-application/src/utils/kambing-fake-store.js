import { defineStore } from 'pinia';
import { ref  } from 'vue';

export const useProdukStore = defineStore('productStore', () => {  
  const listProduk = ref([
      {
          id: 1,
          nomor_telepon: '081234567890',
          nama: 'Smartphone XYZ',
          deskripsi: `
              <h2>Smartphone XYZ</h2>
              <p>The <strong>Smartphone XYZ</strong> is a high-quality smartphone with amazing features. It offers a sleek design and cutting-edge technology to provide an outstanding user experience.</p>
              <ul>
                  <li>High-resolution display</li>
                  <li>Long-lasting battery life</li>
                  <li>Powerful processor</li>
                  <li>Advanced camera features</li>
              </ul>
              <p>Whether you're using it for work or play, the Smartphone XYZ has everything you need to stay connected and productive.</p>`,
          overview: 'High-quality smartphone with amazing features.',
          tags: ['smartphone', 'tech'],
          harga: 6990000,
          gambar: '/images/upload/2024-07-18_1721291307.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 2,
          nomor_telepon: '081234567890',
          nama: 'Laptop ABC',
          deskripsi: `
              <h2>Laptop ABC</h2>
              <p>The <strong>Laptop ABC</strong> is a powerful laptop designed to meet all your computing needs. Its robust hardware and sleek design make it a perfect choice for professionals and gamers alike.</p>
              <ul>
                  <li>High-performance processor</li>
                  <li>Large storage capacity</li>
                  <li>Vibrant display</li>
                  <li>Lightweight and portable</li>
              </ul>
              <p>Experience unparalleled performance and versatility with the Laptop ABC, whether you're working on demanding projects or enjoying the latest games.</p>`,
          overview: 'Powerful laptop for all your computing needs.',
          tags: ['smartphone', 'gadget'],
          harga: 15990000,
          gambar: '/images/upload/12024-07-10_1720650825.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 3,
          nomor_telepon: '081234567890',
          nama: 'Wireless Headphones',
          deskripsi: `
              <h2>Wireless Headphones</h2>
              <p>Enjoy superior sound quality with the <strong>Wireless Headphones</strong>. These headphones are designed for comfort and deliver exceptional audio performance.</p>
              <ul>
                  <li>High-fidelity sound</li>
                  <li>Comfortable ear cushions</li>
                  <li>Long battery life</li>
                  <li>Wireless connectivity</li>
              </ul>
              <p>Perfect for music lovers and professionals alike, these wireless headphones offer the perfect blend of comfort and performance.</p>`,
          overview: 'Comfortable and high-quality sound wireless headphones.',
          tags: ['smartphone', 'electronics'],
          harga: 1990000,
          gambar: '/images/upload/12024-07-13_1720880885.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 4,
          nomor_telepon: '081234567890',
          nama: 'Smartwatch 2021',
          deskripsi: `
              <h2>Smartwatch 2021</h2>
              <p>The <strong>Smartwatch 2021</strong> helps you track your fitness and stay connected on the go. With its sleek design and powerful features, it's more than just a watch.</p>
              <ul>
                  <li>Fitness tracking</li>
                  <li>Heart rate monitoring</li>
                  <li>Notification alerts</li>
                  <li>Water-resistant</li>
              </ul>
              <p>Stay on top of your health and never miss a notification with the Smartwatch 2021.</p>`,
          overview: 'Track your fitness and stay connected.',
          tags: ['smartphone', 'electronics'],
          harga: 2990000,
          gambar: '/images/upload/12024-07-13_1720880889.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 5,
          nomor_telepon: '081234567890',
          nama: 'Gaming Console Pro',
          deskripsi: `
              <h2>Gaming Console Pro</h2>
              <p>Experience next-gen gaming with the <strong>Gaming Console Pro</strong>. This console delivers stunning graphics and smooth performance for an unparalleled gaming experience.</p>
              <ul>
                  <li>4K resolution support</li>
                  <li>High frame rates</li>
                  <li>Extensive game library</li>
                  <li>Immersive audio</li>
              </ul>
              <p>Whether you're a casual gamer or a hardcore enthusiast, the Gaming Console Pro has everything you need to enjoy the latest games in stunning detail.</p>`,
          overview: 'Next-gen gaming console with stunning graphics.',
          tags: ['smartphone', 'electronics'],
          harga: 4999000,
          gambar: '/images/upload/12024-07-13_1720880892.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 6,
          nomor_telepon: '081234567890',
          nama: 'Tablet 2022',
          deskripsi: `
              <h2>Tablet 2022</h2>
              <p>The <strong>Tablet 2022</strong> offers a lightweight design and a crystal-clear display, making it perfect for both work and entertainment.</p>
              <ul>
                  <li>High-resolution display</li>
                  <li>Long battery life</li>
                  <li>Powerful performance</li>
                  <li>Compact and portable</li>
              </ul>
              <p>Stay productive and entertained wherever you go with the versatile Tablet 2022.</p>`,
          overview: 'Lightweight tablet with a crystal-clear display.',
          tags: ['smartphone', 'gadget'],
          harga: 3990000,
          gambar: '/images/upload/12024-07-13_1720880896.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 7,
          nomor_telepon: '081234567890',
          nama: 'Bluetooth Speaker',
          deskripsi: `
              <h2>Bluetooth Speaker</h2>
              <p>Take your music anywhere with the <strong>Bluetooth Speaker</strong>. This portable speaker offers excellent sound quality and a long-lasting battery.</p>
              <ul>
                  <li>High-quality sound</li>
                  <li>Portable design</li>
                  <li>Long battery life</li>
                  <li>Wireless connectivity</li>
              </ul>
              <p>Enjoy your favorite tunes on the go with the convenient and powerful Bluetooth Speaker.</p>`,
          overview: 'Portable speaker with excellent sound quality.',
          tags: ['smartphone', 'gadget'],
          harga: 1290000,
          gambar: '/images/upload/12024-07-16_1721133736.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 8,
          nomor_telepon: '081234567890',
          nama: '4K TV',
          deskripsi: `
              <h2>4K TV</h2>
              <p>Experience vibrant colors and sharp details with the <strong>4K TV</strong>. This Ultra HD TV offers an immersive viewing experience for all your favorite shows and movies.</p>
              <ul>
                  <li>4K Ultra HD resolution</li>
                  <li>High dynamic range (HDR)</li>
                  <li>Smart TV features</li>
                  <li>Wide viewing angles</li>
              </ul>
              <p>Upgrade your home entertainment system with the stunning visuals of the 4K TV.</p>`,
          overview: 'Ultra HD TV with vibrant colors and sharp details.',
          tags: ['smartphone', 'electronics'],
          harga: 7999000,
          gambar: '/images/upload/12024-07-16_1721134121.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 9,
          nomor_telepon: '081234567890',
          nama: 'Digital Camera',
          deskripsi: `
              <h2>Digital Camera</h2>
              <p>Capture stunning photos with the <strong>Digital Camera</strong>. This high-quality camera offers advanced features and excellent performance for both amateurs and professionals.</p>
              <ul>
                  <li>High-resolution sensor</li>
                  <li>Advanced autofocus</li>
                  <li>Manual controls</li>
                  <li>Lightweight and portable</li>
              </ul>
              <p>Take your photography to the next level with the versatile and powerful Digital Camera.</p>`,
          overview: 'Capture stunning photos with this high-quality camera.',
          tags: ['accessories', 'electronics'],
          harga: 2599000,
          gambar: '/images/upload/12024-07-18_1721328802.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 10,
          nomor_telepon: '081234567890',
          nama: 'Smart Home Hub',
          deskripsi: `
              <h2>Smart Home Hub</h2>
              <p>Control your smart home devices with ease using the <strong>Smart Home Hub</strong>. This hub integrates all your smart devices into a single, easy-to-use platform.</p>
              <ul>
                  <li>Universal compatibility</li>
                  <li>Easy setup and control</li>
                  <li>Voice assistant support</li>
                  <li>Secure and reliable</li>
              </ul>
              <p>Enhance your smart home experience with the convenient and powerful Smart Home Hub.</p>`,
          overview: 'Control your smart home devices with ease.',
          tags: ['smartphone', 'tech'],
          harga: 3490000,
          gambar: '/images/upload/12024-07-18_1721329075.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 11,
          nomor_telepon: '081234567890',
          nama: 'Wireless Charger',
          deskripsi: `
              <h2>Wireless Charger</h2>
              <p>Keep your devices powered up with the <strong>Wireless Charger</strong>. This charger is compatible with a wide range of devices and offers fast and convenient charging.</p>
              <ul>
                  <li>Fast charging</li>
                  <li>Wide compatibility</li>
                  <li>Sleek design</li>
                  <li>Safe and efficient</li>
              </ul>
              <p>Make charging easy and efficient with the sleek and powerful Wireless Charger.</p>`,
          overview: 'Fast and convenient wireless charger.',
          tags: ['smartphone', 'accessories'],
          harga: 199000,
          gambar: '/images/upload/12024-07-18_1721330520.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 12,
          nomor_telepon: '081234567890',
          nama: 'VR Headset',
          deskripsi: `
              <h2>VR Headset</h2>
              <p>Immerse yourself in virtual reality with the <strong>VR Headset</strong>. This headset offers high-quality visuals and a comfortable design for an amazing VR experience.</p>
              <ul>
                  <li>High-resolution display</li>
                  <li>Comfortable fit</li>
                  <li>Wide field of view</li>
                  <li>Easy setup</li>
              </ul>
              <p>Explore new worlds and experience games and media like never before with the VR Headset.</p>`,
          overview: 'Immerse yourself in virtual reality with this high-quality headset.',
          tags: ['smartphone', 'electronics'],
          harga: 4999000,
          gambar: '/images/upload/12024-07-18_1721342538.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 13,
          nomor_telepon: '081234567890',
          nama: 'Portable Projector',
          deskripsi: `
              <h2>Portable Projector</h2>
              <p>Take your presentations and movie nights anywhere with the <strong>Portable Projector</strong>. This compact projector offers bright and clear images in a portable package.</p>
              <ul>
                  <li>Bright and clear projection</li>
                  <li>Compact and lightweight</li>
                  <li>Easy setup</li>
                  <li>Multiple connectivity options</li>
              </ul>
              <p>Enjoy the convenience of a portable projector that delivers excellent performance wherever you go.</p>`,
          overview: 'Compact and lightweight portable projector.',
          tags: ['smartphone', 'gadget'],
          harga: 2990000,
          gambar: '/images/upload/12024-07-19_1721349580.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 14,
          nomor_telepon: '081234567890',
          nama: 'Smart Thermostat',
          deskripsi: `
              <h2>Smart Thermostat</h2>
              <p>Control your home temperature with ease using the <strong>Smart Thermostat</strong>. This thermostat offers remote control and energy-saving features for a comfortable and efficient home.</p>
              <ul>
                  <li>Remote control</li>
                  <li>Energy-saving features</li>
                  <li>Easy installation</li>
                  <li>Compatible with smart home systems</li>
              </ul>
              <p>Keep your home comfortable and save on energy bills with the Smart Thermostat.</p>`,
          overview: 'Efficient and convenient smart thermostat.',
          tags: ['smartphone', 'home'],
          harga: 1799000,
          gambar: '/images/upload/32024-07-18_1721325812.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 15,
          nomor_telepon: '081234567890',
          nama: 'Smart Light Bulbs',
          deskripsi: `
              <h2>Smart Light Bulbs</h2>
              <p>Illuminate your home with the <strong>Smart Light Bulbs</strong>. These bulbs offer customizable lighting options and remote control for convenience and energy efficiency.</p>
              <ul>
                  <li>Customizable lighting</li>
                  <li>Remote control</li>
                  <li>Energy efficient</li>
                  <li>Easy installation</li>
              </ul>
              <p>Enhance your home lighting experience with the versatile and efficient Smart Light Bulbs.</p>`,
          overview: 'Convenient and energy-efficient smart light bulbs.',
          tags: ['smartphone', 'home'],
          harga: 99000,
          gambar: '/images/upload/32024-07-18_1721325865.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 16,
          nomor_telepon: '081234567890',
          nama: 'Smart Door Lock',
          deskripsi: `
              <h2>Smart Door Lock</h2>
              <p>Secure your home with the <strong>Smart Door Lock</strong>. This lock offers advanced security features and convenient remote access for peace of mind.</p>
              <ul>
                  <li>Advanced security</li>
                  <li>Remote access</li>
                  <li>Easy installation</li>
                  <li>Compatible with smart home systems</li>
              </ul>
              <p>Protect your home with the reliable and convenient Smart Door Lock.</p>`,
          overview: 'Advanced security and convenient remote access.',
          tags: ['smartphone', 'home'],
          harga: 3999000,
          gambar: '/images/upload/32024-07-18_1721325914.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 17,
          nomor_telepon: '081234567890',
          nama: 'Smart Security Camera',
          deskripsi: `
              <h2>Smart Security Camera</h2>
              <p>Monitor your home with the <strong>Smart Security Camera</strong>. This camera offers high-definition video and remote access for enhanced security.</p>
              <ul>
                  <li>High-definition video</li>
                  <li>Remote access</li>
                  <li>Night vision</li>
                  <li>Easy installation</li>
              </ul>
              <p>Keep your home safe with the reliable and advanced Smart Security Camera.</p>`,
          overview: 'High-definition video and remote access for enhanced security.',
          tags: ['smartphone', 'home'],
          harga: 2499000,
          gambar: '/images/upload/32024-07-18_1721325926.png',
          sedang_dijual: true,
          pin: false,
      },
      {
          id: 18,
          nomor_telepon: '081234567890',
          nama: 'Smart Light Switch',
          deskripsi: `
              <h2>Smart Light Switch</h2>
              <p>Control your home lighting with ease using the <strong>Smart Light Switch</strong>. This switch offers remote control and customizable settings for convenience and efficiency.</p>
              <ul>
                  <li>Remote control</li>
                  <li>Customizable settings</li>
                  <li>Energy efficient</li>
                  <li>Easy installation</li>
              </ul>
              <p>Enhance your home lighting experience with the convenient and efficient Smart Light Switch.</p>`,
          overview: 'Convenient and efficient smart light switch.',
          tags: ['smartphone', 'home'],
          harga: 199000,
          gambar: '/images/upload/32024-07-18_1721325941.png',
          sedang_dijual: true,
          pin: false,
      },
  ]);

  const tags = ref(['smartphone', 'electronics', 'gadget', 'accessories', 'tech']);
  const listTagProduk = ref([]);


  const createProduk = product => {
    product.id = Date.now();
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

  return {
    listProduk,
    tags,
    listTagProduk,
    createProduk,
    readProduk,
    updateProduk,
    deleteProduk,
    searchProduk,
  };
});
