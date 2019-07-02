/******ͷ �� ��******/
#include<stdio.h>	//��׼�������������
#include<time.h>	//���ڻ�������
#include<windows.h>	//����dos����
#include<stdlib.h>	//�� standard library ��־��ͷ�ļ������涨����һЩ���ͨ�ù��ߺ���
#include<conio.h>	//���ܼ����������

/******�� �� ��******/
#define U 1
#define D 2
#define L 3
#define R 4						//�ߵ�״̬��U���ϣ�D���£�L����R����

/******�� �� ȫ �� �� ��******/
typedef struct snake{	//�����һ���ڵ�
	int x;	//�ڵ��x����
	int y;	//�ڵ��y����
	struct snake *next;	//�������һ�ڵ�
}snake;
int score=0,add=10;	//�ܵ÷���ÿ�γ�ʳ��÷�
int highScore;	//��߷�
int status,sleeptime=200;	//��ǰ��״̬��ÿ�����е�ʱ����
snake *head,*food;	//��ͷָ�룬ʳ��ָ��
snake *q;	//�����ߵ�ʱ���õ���ָ��
int endgamestatus=0;	//��Ϸ�����������1��ײ��ǽ��2��ҧ���Լ���3�������˳���Ϸ
HANDLE hOut;	//����̨���

/******�� �� �� ��******/
void gotoxy(int x,int y);	//���ù��λ��
int color(int c);	//����������ɫ
void printsnake();	//�ַ�������������
void welcometogame();	//��ʼ����
void createMap();	//���Ƶ�ͼ
void scoreendtips();	//��Ϸ�����Ҳ�ĵ÷ֺ�С��ʾ
void initsnake();	//��ʼ���ߣ�������
void createfood();	//�������������ʳ��
int biteself();	//�ж��Ƿ�ҧ�����Լ�
void cantcrosswall();	//������ײǽ�����
void speedup();	//����
void speeddown();	//����
void snakemove();	//������ǰ������
void keyboardControl();	//���Ƽ��̰���
void lostdraw();	//��Ϸ��������
void endgame();	//��Ϸ����
void choose();	//��Ϸʧ��֮���ѡ��
void file_out();	//���ļ��ж�ȡ��߷�
void file_in();	//�洢��߷ֽ��ļ�
void explation();	//��Ϸ˵��

/*������ɫ����*/
int color(int c){
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE),c);
	return 0;
}

/*���ù��λ��*/
void gotoxy(int x,int y){
	COORD c;
	c.X=x;
	c.Y=y;
	SetConsoleCursorPosition(GetStdHandle(STD_OUTPUT_HANDLE),c);
}

/*�ַ�������������*/
void printsnake(){
	gotoxy(35,1);
	color(6);
	printf("/^\\/^\\");	//���۾�
	
	gotoxy(34,2);
	printf("|__|  O|");	//���۾�
	
	gotoxy(33,2);
	color(2);
	printf("_");
	
	gotoxy(25,3);
	color(12);
	printf("\\/");	//����
	
	gotoxy(31,3);
	color(2);
	printf("/");
	
	gotoxy(37,3);
	color(6);
	printf("\\_/");	//���۾�
	
	gotoxy(41,3);
	color(10);
	printf("\\");
	
	gotoxy(26,4);
	color(12);
	printf("\\____");	//��ͷ
	
	gotoxy(32,4);
	printf("________/");
	
	gotoxy(31,4);
	color(2);
	printf("|");
	
	gotoxy(43,4);
	color(10);
	printf("\\");
	
	gotoxy(32,5);
	color(2);
	printf("\\_______");	//����
	
	gotoxy(44,5);
	color(10);
	printf("\\");
	
	gotoxy(39,6);	//���涼�ǻ�����
	printf("|     |	                 \\");
	
	gotoxy(38,7);
	printf("/      /                    \\");
	
	gotoxy(37,8);
	printf("/      /                     \\ \\");
	
	gotoxy(35,9);
	printf("/      /                        \\ \\");
	
	gotoxy(34,10);
	printf("/     /                           \\  \\");
	
	gotoxy(33,11);
	printf("/     /             _----_          \\   \\");
	
	gotoxy(32,12);
	printf("/     /           _-~      ~-_          |  |");
	
	gotoxy(31,13);
	printf("(     (        _-~     _--_     ~-_     _/  |");
	
	gotoxy(32,14);
	printf("\\    ~-____-~      _-~   ~-_     ~-_-~    /");
	
	gotoxy(33,15);
	printf("~-_           _-~           ~-_       _-~");
	
	gotoxy(35,16);
	printf("~--______-~                  ~-__-~");
}

/*��ʼ����*/
void welcometogame(){
	int n;
	int i,j=1;
	gotoxy(43,18);
	printf("̰ �� �� �� Ϸ");
	color(14);	//��ɫ�߿�
	for(i=20;i<=26;i++){	//����±߿�---
		for(j=27;j<=74;j++){	//������ұ߿�|
			gotoxy(j,i);
			if(i==20 || i==26){
				printf("-");
			}else if(j==27 || j==74){
				printf("|");
			}
		}
	}
	color(12);
	gotoxy(35,22);
	printf("1.��ʼ��Ϸ");
	gotoxy(55,22);
	printf("2.��Ϸ˵��");
	gotoxy(35,24);
	printf("3.�˳���Ϸ");
	gotoxy(29,27);
	color(3);
	printf("��ѡ��[1 2 3]:[]\b\b");	//\bΪ�˸�ʹ��괦��[]�м�
	color(14);
	scanf("%d",&n);	//����ѡ��
	switch(n){	//3��ѡ��
		case 1:	//ѡ��1����û�����ѡ�����ݣ�֮�����
			system("cls");	//����
		break;	
		case 2:	//ѡ��2����û�����ѡ�����ݣ�֮�����
		break;	
		case 3:	//ѡ��3����û�����ѡ�����ݣ�֮�����
			exit(0);	//�˳�����
		break;
		default:	//�����1~3��ѡ��
			color(12);
			gotoxy(40,28);
			printf("������1~3֮�������");
			getch();	//���������
			system("cls");	//����
			printsnake();
			welcometogame();
	}
}

/*������*/
int main(){
	system("mode con cols=100 lines=30");	//���ÿ���̨���
	printsnake();	//�����ַ���
	welcometogame();	//������ӵ����
	getchar(); 
}


















