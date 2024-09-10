<?php include('constants.php')?>

<div>
    <h1>About Pic 1</h1>
    <div v-if="message" v-html="message"></div>
    <form @submit.prevent="SubnitAboutPicOne" enctype="multipart/form-data">
      <table>
        <tr>
          <td>Current Image:</td>
          <td>
            <img v-if="currentImage" :src="currentImageUrl" width="150px">
            <div v-else class="error">Image Not Added</div>
          </td>
        </tr>
        
        <tr>
          <td>Select Image:</td>
          <td>
            <input type="file" @change="handleFileUpload">
          </td>
        </tr>

        <tr>
          <td>
            <input type="submit" value="確定更新">
          </td>
        </tr>
      </table>
    </form>
    <table>

    </table>
  </div>