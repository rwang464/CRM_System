/* eslint-disable class-methods-use-this */
import axios from 'axios';

const baseUrl = 'http://localhost:3000/src/views/api/api.php?action=';
interface ICallApiOption {
  method: string;
  params?: { [key: string]: any };
  data?: { [key: string]: any };
}

interface IResult {
  status: number;
  msg: string;
  code: number;
  data: any;
}

class HttpHelper {
  // eslint-disable-next-line class-methods-use-this
  callApi = async (url: string, options: ICallApiOption): Promise<IResult> => {
    const { method, params, data } = options;
    const opt = { url: `${baseUrl}${url}`, method, params, data };
    if (method === 'get') {
      delete opt.data;
    }
    const res: any = await axios(opt);
    return res.data as IResult;
  };

  get = (url: string, params: { [key: string]: any }) =>
    this.callApi(url, { method: 'get', params });

  post = (
    url: string,
    data: { [key: string]: any },
    params?: { [key: string]: any }
  ) => this.callApi(url, { method: 'post', data, params });

  put = (
    url: string,
    data: { [key: string]: any },
    params?: { [key: string]: any }
  ) => this.callApi(url, { method: 'put', data, params });

  delete = (url: string, params?: { [key: string]: any }) =>
    this.callApi(url, { method: 'delete', params });

  getValue(key: string): any {
    const str = sessionStorage.getItem(key);
    if (str) {
      const res = JSON.parse(str).c;
      return res;
    }
    return null;
  }

  setValue(key: string, value: any): void {
    const newValue: string = JSON.stringify({ c: value });
    sessionStorage.setItem(key, newValue);
  }
}

export default new HttpHelper();
