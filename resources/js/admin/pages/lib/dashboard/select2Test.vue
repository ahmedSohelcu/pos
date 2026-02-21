<template>
  <div :class="['container-fluid mt-2', isDark ? 'bg-dark text-light' : 'bg-light text-dark']">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 shadow-sm rounded"
         :class="isDark ? 'bg-gray-900 text-light' : 'bg-white'">
      <div class="d-flex align-items-center gap-3">
        <img src="https://via.placeholder.com/50" alt="logo">
        <h3 class="mb-0">My Store POS</h3>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span>{{ datetime }}</span>
        <strong>User:</strong> {{ user.name }}
        <button class="btn btn-sm btn-outline-primary" @click="toggleDarkMode">
          {{ isDark ? 'Light Mode' : 'Dark Mode' }}
        </button>
      </div>
    </div>

    <div class="row">
      <!-- Sidebar Filters -->
      <div class="col-md-2 mb-3">
        <h5>Category</h5>
        <button
          v-for="cat in categories"
          :key="cat.name"
          class="btn mb-2 w-100"
          :class="cat.name===selectedCategory ? cat.colorClass:'btn-outline-secondary'"
          @click="filterCategory(cat.name)"
        >
          {{ cat.name }} <span v-if="cat.alert" class="badge bg-danger">{{ cat.alert }}</span>
        </button>
        <button class="btn btn-outline-dark w-100 mb-3" @click="filterCategory('')">All</button>

        <h5>Brand</h5>
        <select v-model="selectedBrand" class="form-select mb-3">
          <option value="">All Brands</option>
          <option v-for="b in brands" :key="b">{{ b }}</option>
        </select>
      </div>

      <!-- Product Grid -->
      <div class="col-md-7">
        <input
          type="text"
          class="form-control mb-3"
          placeholder="Search Products / Scan Barcode"
          v-model="searchQuery"
          @keydown.enter="handleBarcodeAdd"
        >
        <div class="row g-3" style="max-height: 75vh; overflow-y:auto;" @scroll="handleScroll">
          <div class="col-2" v-for="product in displayedProducts" :key="product.id">
            <div class="card product-card position-relative shadow-sm h-100">
              <img :src="product.image" class="card-img-top product-image" :alt="product.name">
              <div class="card-body p-2 text-center">
                <h6 class="card-title mb-1">{{ product.name }}</h6>
                <p class="mb-1 fw-bold text-success">$ {{ product.price.toFixed(2) }}</p>
                <span class="badge bg-info text-dark">{{ product.category }}</span>
                <span class="badge bg-secondary">{{ product.unit }}</span>
              </div>
              <button class="btn btn-sm btn-primary cart-btn position-absolute bottom-0 end-0 m-1"
                      @click="addToCart(product.id)">
                <i class="bi bi-cart-plus-fill"></i>
              </button>
              <span v-if="product.lowStock" class="badge bg-warning text-dark position-absolute top-0 start-0 m-1">Low Stock</span>
              <span v-if="product.expirySoon" class="badge bg-danger position-absolute top-0 end-0 m-1">Expiring</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Cart Panel -->
      <div class="col-md-3">
        <div :class="['cart-panel sticky-top p-3 shadow-sm rounded', isDark?'bg-gray-900 text-light':'bg-white']">
          <div class="d-flex justify-content-between mb-3">
            <select v-model="selectedCustomer" class="form-select w-100">
              <option value="">Walk-in Customer</option>
              <option v-for="c in customers" :key="c">{{ c }}</option>
            </select>
          </div>

          <h5 class="mb-3">Cart</h5>
          <div v-for="item in cart" :key="item.id" class="cart-item mb-2">
            <div>
              <strong>{{ item.name }}</strong>
              <div class="d-flex align-items-center gap-1 mt-1">
                <input v-if="item.unit.includes('kg') || item.unit.includes('g')" type="number" min="0" placeholder="kg" class="form-control form-control-sm w-50" v-model.number="item.kg">
                <input v-if="item.unit.includes('kg') || item.unit.includes('g')" type="number" min="0" placeholder="g" class="form-control form-control-sm w-50" v-model.number="item.g">
                <button class="btn btn-sm btn-outline-secondary" @click="increaseQty(item.id)">+</button>
                <button class="btn btn-sm btn-outline-secondary" @click="decreaseQty(item.id)">-</button>
              </div>
              <small v-if="item.loyaltyPoints">Loyalty: {{ item.loyaltyPoints }}</small>
            </div>
            <div class="text-end">
              ${{ itemTotal(item).toFixed(2) }}
              <button class="btn btn-sm btn-danger ms-2" @click="removeItem(item.id)">x</button>
            </div>
          </div>

          <div class="mt-3">
            <div class="d-flex justify-content-between"><span>Subtotal:</span> <span>${{ subtotal.toFixed(2) }}</span></div>
            <div class="d-flex justify-content-between"><span>Tax (5%):</span> <span>${{ tax.toFixed(2) }}</span></div>
            <div class="d-flex justify-content-between">
              <span>Discount:</span>
              <input type="number" class="form-control form-control-sm w-50" v-model.number="discount">
            </div>
            <div class="d-flex justify-content-between mt-2">
              <span>Cash Received:</span>
              <input type="number" class="form-control form-control-sm w-50" v-model.number="cashReceived">
            </div>
            <div class="d-flex justify-content-between mt-2">
              <span>Return:</span>
              <span>${{ returnAmount.toFixed(2) }}</span>
            </div>
            <hr>
            <div class="total-section d-flex justify-content-between fw-bold fs-5">Total: ${{ total.toFixed(2) }}</div>
          </div>

          <button class="btn btn-success w-100 mt-3" @click="openBillPreview">Bill Preview / Print</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
    import { ref, computed, onMounted } from 'vue';
    import 'bootstrap/dist/css/bootstrap.min.css';
    import 'bootstrap/dist/js/bootstrap.bundle.min.js';
    // import 'bootstrap-icons/font/bootstrap-icons.css';

    const user = ref({ name: 'Ahmed' });
    const isDark = ref(false);
    const toggleDarkMode = () => { isDark.value = !isDark.value; };

    const categories = ref([{ name: 'Grocery', colorClass: 'btn-primary', alert: null },
                        { name: 'Medicine', colorClass: 'btn-success', alert: '2 Expiring' },
                        { name: 'Beverages', colorClass: 'btn-warning', alert: null },
                        { name: 'Snacks', colorClass: 'btn-info', alert: null }]);
    const brands = ref(['Brand A','Brand B','Brand C']);
    const customers = ref(['Customer 1','Customer 2','Customer 3']);

    const selectedCategory = ref('');
    const selectedBrand = ref('');
    const selectedCustomer = ref('');
    const searchQuery = ref('');
    const discount = ref(0);
    const cashReceived = ref(0);

    const imgUrls =ref(['https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/1.webp',
        'https://cdn.dummyjson.com/product-images/beauty/powder-canister/1.webp',
        'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp',
        "https://cdn.dummyjson.com/product-images/beauty/red-nail-polish/1.webp",
        "https://cdn.dummyjson.com/product-images/fragrances/calvin-klein-ck-one/thumbnail.webp",
        "https://cdn.dummyjson.com/public/qr-code.png"
    ]);

    const products = ref(Array.from({length:50},(_,i)=>({
        id:i+1,
        name:`Product ${i+1}`,
        category: ['Grocery','Medicine','Beverages','Snacks'][i%4],
        brand: ['Brand A','Brand B','Brand C'][i%3],
        price:(i+1)*1.5,
        unit: ['500g','1kg','1L','5kg','50g'][i%5],
        image: ref(Math.random() * imgUrls.value.length | 0) >= imgUrls.value.length ? imgUrls.value[imgUrls.value.length-1] : imgUrls.value[Math.floor(Math.random() * imgUrls.value.length)],
        lowStock:i%10===0,
        expirySoon:i%15===0,
        loyaltyPoints: i%5
    })));



    const cart = ref([]);
    const displayedProductsCount = ref(12);
    const displayedProducts = computed(()=>filteredProducts.value.slice(0,displayedProductsCount.value));
    const datetime = ref('');
    onMounted(()=>{ datetime.value = new Date().toLocaleString(); });

    const filteredProducts = computed(()=>products.value.filter(p=>
    (selectedCategory.value===''||p.category===selectedCategory.value) &&
    (selectedBrand.value===''||p.brand===selectedBrand.value) &&
    p.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    ));

    function addToCart(id){
    const product = products.value.find(p=>p.id===id);
    const item = cart.value.find(i=>i.id===id);
    if(item) item.qty+=1;
    else cart.value.push({...product, qty:1, kg:0, g:0, itemDiscount:0});
    }

    function increaseQty(id){ const item=cart.value.find(i=>i.id===id); if(item)item.qty+=1; }
    function decreaseQty(id){ const item=cart.value.find(i=>i.id); if(item && item.qty>1)item.qty-=1; }
    function removeItem(id){ cart.value = cart.value.filter(i=>i.id!==id); }
    function filterCategory(cat){ selectedCategory.value=cat; }

    const subtotal = computed(()=>cart.value.reduce((sum,i)=>sum+(i.price-i.itemDiscount||0)*i.qty,0));
    const tax = computed(()=>subtotal.value*0.05);
    const total = computed(()=>subtotal.value+tax.value-discount.value);
    const returnAmount = computed(()=>Math.max(0,cashReceived.value-total));

    function itemTotal(item){
    if(item.kg!==undefined || item.g!==undefined){
        const weightKg = (item.kg||0)+ (item.g||0)/1000;
        return (item.price*weightKg*item.qty);
    }
    return (item.price*item.qty);
    }

    let billModal = null;
    function openBillPreview(){ alert('Bill Preview Here'); }
    function handleScroll(e){ const div = e.target; if(div.scrollTop + div.clientHeight >= div.scrollHeight-10) displayedProductsCount.value += 6; }
    function handleBarcodeAdd(e){
    const product = products.value.find(p=>p.name.toLowerCase()===searchQuery.value.toLowerCase());
    if(product) addToCart(product.id);
    searchQuery.value = '';
    }
</script>

<style scoped>
    .bg-gray-900 { background:#1f1f1f!important; }
    .product-card{cursor:pointer;transition:transform 0.2s;position:relative;height:100%;border-radius:8px;}
    .product-card:hover{transform:scale(1.05);}
    .cart-panel{padding:15px;border-radius:8px;box-shadow:0 0 20px rgba(0,0,0,0.3);}
    .cart-item{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .total-section{font-weight:bold;font-size:1.3rem;margin-top:10px;}
    .product-image{height:100px;object-fit:cover;border-radius:4px;}
    .cart-btn{border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;}
    .category-btn{display:flex;justify-content:space-between;align-items:center;}
</style>