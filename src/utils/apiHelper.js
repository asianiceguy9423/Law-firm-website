import axios from 'axios';
import { eventBus } from '@/eventBus';

export async function callApi(method, url, data = null, headers = {}) {
  try {
    const response = await axios({ method, url, data, headers });
    const result = response.data;

    if (result.success) {
      // console.log('aipHelper:yes')
      return { 
        success: true, 
        data: result, 
        message: result.message 
      };
    } else {
      // console.log('aipHelper:no')
      eventBus.emit(
        'sentErrorMessage', 
        result.message
      );
      return { 
        success: false, 
        message: result.message 
      };
    }
  } catch (error) {
    // console.log('aipHelper:error')
    eventBus.emit(
      'sentErrorMessage', 
      error.message
    );
    return { 
      success: false, 
      message: error.message 
    };
  }
}
