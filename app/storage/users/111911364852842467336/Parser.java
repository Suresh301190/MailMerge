public class Main{

	static final PrintStream ps = new PrintStream(System.out);
	static InputStream is;
	
	public static void main(String[] args) throws Exception {
		// TODO Auto-generated method stub	
		if(args.length>0 && args[0].equals("Test")){
			is= new BufferedInputStream(new FileInputStream(new java.io.File("Input")));
		}
		else{
			is = System.in;
		}

		Main m = new Main();
		m.work();
	}
	
	private void work() throws Exception{
		Parser p = new Parser(is);
		
	}
	
	static class Parser {
		final private int BufferSize = 65536,Init=0;
		private BufferedInputStream bis;
		private byte read;
		private int BufferPointer,BufferEnd;
		private byte[] buffer = new byte[BufferSize];

		Parser(InputStream in) throws Exception{
			bis = new BufferedInputStream(in);
			BufferPointer = 0;
			BufferEnd = bis.read(buffer, Init, BufferSize);		
		}
		
		private byte readNext() throws Exception{
			if(BufferPointer == BufferEnd)fillBuffer();
			return buffer[BufferPointer++];
		}

		private void fillBuffer() throws Exception {
			BufferPointer = Init;
			BufferEnd = bis.read(buffer, Init, BufferSize);
			if(BufferEnd == -1)buffer[0] = -1;
		}

		public int nextInt() throws Exception{
			int num = 0;
			read = readNext();
			while(read <=' ')read = readNext();
			boolean neg = read == '-';
			if(neg)read = readNext();
			do{
				num = num * 10 + (read - '0');
				read = readNext();
			}while(read > ' ');
			if(neg)return -num;
			return num;
		}

		public char nextChar() throws Exception {
			read=readNext();
			while(read <= ' ')read = readNext();
			return (char) read;
		}
		
		public char nextAnyChar() throws Exception {
			read=readNext();
			return (char) read;
		}

		public String nextString() throws Exception {
			StringBuffer sb = new StringBuffer("");
			read = readNext();
			while(read <= ' ')read = readNext();
			do{
				sb.append((char) read);
				read = readNext();
			}while(read > ' ');
			return sb.toString();
		}
		
		public void nextSkip() throws Exception{
			read = readNext();
			while(read <= ' ')read = readNext();
			read = readNext();
			while(read > ' ')read = readNext();
		}
	}
}