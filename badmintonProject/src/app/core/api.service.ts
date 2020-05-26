
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {User} from "../model/user.model";
import {Observable} from "rxjs/index";
import {ApiResponse} from "../model/api.response";

@Injectable()
export class ApiService {

  constructor(private http: HttpClient) { }
  baseUrl: string = 'http://localhost/slimapp/public/index.php/api1/students/';

  login(loginPayload) : Observable<ApiResponse> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json'
      })
    }
    return this.http.post<ApiResponse>('http://slimapp/api1/login', loginPayload, httpOptions);
  }

  leaderboard(loginPayload) : Observable<ApiResponse> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json'
      })
    }
    return this.http.post<ApiResponse>('http://slimapp/api1/leaderboard', loginPayload, httpOptions);
  }
  bidderlogin(loginPayload) : Observable<ApiResponse> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json'
      })
    }
    return this.http.post<ApiResponse>('http://slimapp/api1/bidderlogin', loginPayload, httpOptions);
  }

  getUsers(id:number) : Observable<ApiResponse> {
    return this.http.get<ApiResponse>(this.baseUrl+id);
  }
  dropdown(id:number) : Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/dropdown/'+id);
  }
  bidddinghistory(id:number) : Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/biddinghistory/'+id);
  }
  credits(id:number) : Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/credits/'+id);
  }
  matches() : Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/matches');
  }
  finishedMatches() : Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/finishedMatches');
  }

  getUserById(id: number): Observable<ApiResponse> {
    return this.http.get<ApiResponse>(this.baseUrl + id);
  }
  getNameById(id: number): Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/studentName'+ id);
  }
  getResult(tournament: number): Observable<ApiResponse> {
    return this.http.get<ApiResponse>('http://slimapp/api1/biddingResult/'+tournament);
  }

  createUser(user: any): Observable<ApiResponse> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json'
      })
    }
    console.log(user);
    return this.http.post<ApiResponse>('http://localhost/slimapp/public/index.php/api1/register',user,httpOptions);
  }

  bidding(user: any): Observable<ApiResponse> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':  'application/json'
      })
    }
    return this.http.post<ApiResponse>('http://localhost/slimapp/public/index.php/api1/bidding',user,httpOptions);
  }
  

  updateUser(user:any): Observable<ApiResponse> {
    const httpOptions = 
       new HttpHeaders({
        'Authorization': 'Bearer '+localStorage.getItem('token')

      })
    
    return this.http.put<ApiResponse>('http://slimapp/api1/update',user,{headers:httpOptions});
  }

  deleteUser(id: number): Observable<ApiResponse> {
    return this.http.delete<ApiResponse>(this.baseUrl + id);
  }
}
