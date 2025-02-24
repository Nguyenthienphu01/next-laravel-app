<template>
  <div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6">Tạo một học phần mới</h1>

    <!-- Controls -->
    <div class="flex gap-4 mb-6">
      <button
        class="flex items-center gap-2 px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        <span>Nhập</span>
        <PlusIcon class="w-4 h-4" />
      </button>

      <button
        class="flex items-center gap-2 px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        <span>Thêm sơ đồ</span>
        <LockIcon class="w-4 h-4" />
      </button>

      <button
        class="flex items-center gap-2 px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        <span>Tạo từ ghi chú</span>
        <FileTextIcon class="w-4 h-4" />
      </button>
    </div>

    <!-- Flashcard Form -->
    <div class="mt-8">
      <!-- Card -->
      <div
        v-for="(card, index) in cards"
        :key="card.id"
        class="bg-white rounded-lg shadow-sm p-6 mb-4"
      >
        <div class="flex items-start">
          <span class="text-gray-500 mr-4 mt-2">{{ index + 1 }}</span>

          <div class="flex-1">
            <!-- Term Input -->
            <div class="mb-4">
              <div class="flex justify-between items-center mb-1">
                <label class="text-xs text-gray-500">THUẬT NGỮ</label>
                <span class="text-xs text-blue-500">TIẾNG ANH</span>
              </div>
              <input
                v-model="card.term"
                type="text"
                class="w-full border-b border-gray-200 focus:border-blue-500 outline-none py-2 transition-colors"
                placeholder="Nhập thuật ngữ"
              />
            </div>

            <!-- Definition Input -->
            <div class="mb-4">
              <div class="flex justify-between items-center mb-1">
                <label class="text-xs text-gray-500">ĐỊNH NGHĨA</label>
                <span class="text-xs text-blue-500">TIẾNG VIỆT</span>
              </div>
              <input
                v-model="card.definition"
                type="text"
                class="w-full border-b border-gray-200 focus:border-blue-500 outline-none py-2 transition-colors"
                placeholder="Nhập định nghĩa"
              />
            </div>
          </div>

          <!-- Image Upload -->
          <div class="ml-4">
            <button
              class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
            >
              <div class="text-center">
                <ImageIcon class="w-6 h-6 mx-auto text-gray-400" />
                <span class="block text-sm text-gray-400 mt-2">Hình ảnh</span>
              </div>
            </button>
          </div>
        </div>

        <!-- Card Controls -->
        <div class="flex justify-end gap-2 mt-4">
          <button
            @click="removeCard(card.id)"
            class="text-gray-400 hover:text-gray-600 transition-colors"
          >
            <MinusIcon class="w-5 h-5" />
          </button>
          <button class="text-gray-400 hover:text-gray-600 transition-colors">
            <SquareIcon class="w-5 h-5" />
          </button>
        </div>
      </div>

      <!-- Add Card Button -->
      <button
        @click="addCard"
        class="w-full text-center text-blue-500 hover:text-blue-600 font-medium py-3 transition-colors"
      >
        <PlusIcon class="w-5 h-5 inline mr-1" />
        THÊM THẺ
      </button>
    </div>

    <!-- Bottom Buttons -->
    <div class="flex justify-between mt-8">
      <button
        class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-50 transition-colors"
      >
        Tạo
      </button>
      <button
        class="px-6 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors"
      >
        Tạo và ôn luyện
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import {
  PlusIcon,
  LockIcon,
  FileTextIcon,
  ImageIcon,
  MinusIcon,
  SquareIcon,
} from "lucide-vue-next";

interface Card {
  id: number;
  term: string;
  definition: string;
  image: string | null;
}

const cards = ref<Card[]>([{ id: 1, term: "", definition: "", image: null }]);

const addCard = () => {
  const newId = cards.value.length + 1;
  cards.value.push({
    id: newId,
    term: "",
    definition: "",
    image: null,
  });
};

const removeCard = (id: number) => {
  if (cards.value.length > 1) {
    cards.value = cards.value.filter((card) => card.id !== id);
  }
};
</script>
